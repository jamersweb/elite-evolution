<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Services\ListingImporter;
use App\Services\PropertyFinderListings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Throwable;

class SyncListings extends Command
{
    protected $signature = 'listings:sync {--apply : Save changes after validation}
        {--property-finder : Use the Property Finder API regardless of the CRM export setting}
        {--limit= : Pilot with at most this many listings}
        {--file= : Local CRM active-listings JSON export}
        {--withdraw : Hide previously imported listings missing from a complete feed}';
    protected $description = 'Preview or apply a CRM export or authorised Property Finder listings snapshot';

    public function handle(PropertyFinderListings $api, ListingImporter $importer)
    {
        $limit = $this->option('limit');
        $apply = $this->option('apply');
        $withdraw = $this->option('withdraw');
        if (($limit !== null && (!ctype_digit($limit) || (int) $limit < 1)) || ($limit && $withdraw)) {
            $this->error('Use a positive limit. Withdrawal requires a full sync.');
            return 1;
        }
        $lock = Cache::lock('listing-catalogue-sync', 3600);
        if (!$lock->get()) {
            $this->error('Another listing sync is running.');
            return 1;
        }
        try {
            $file = $this->option('property-finder') ? null : ($this->option('file') ?: config('listing_sync.feed'));
            $source = $file ? 'crm' : 'propertyfinder';
            if ($file) {
                if (!is_file($file) || !is_readable($file)) {
                    throw new RuntimeException('CRM export must be a readable local file.');
                }
                $feed = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
                $rows = $feed['results'] ?? null;
                if (!is_array($rows) || ($feed['total'] ?? null) !== count($rows)) {
                    throw new RuntimeException('CRM export requires results and a matching integer total.');
                }
                if ($limit) {
                    $rows = array_slice($rows, 0, (int) $limit);
                }
            } else {
                $rows = $api->fetch($limit ? (int) $limit : null);
            }
            if (!$rows && $withdraw) {
                throw new RuntimeException('Empty feed. Automatic withdrawal of the entire catalogue is blocked.');
            }
            $seen = [];
            $added = $updated = $hidden = 0;
            DB::beginTransaction();
            try {
                foreach ($rows as $row) {
                    $id = $row['id'] ?? '';
                    if (isset($seen[$id]) || data_get($row, 'state.stage', 'live') !== 'live'
                        || data_get($row, 'portals.propertyfinder.isLive', true) === false && $source === 'propertyfinder') {
                        throw new RuntimeException('Duplicate ID or inactive listing in active snapshot.');
                    }
                    $seen[$id] = true;
                    $created = $importer->import($row, $source);
                    if ($limit) {
                        $this->line(sprintf('%s %s (%s)', $created ? 'New' : 'Matched', $row['reference'], data_get($row, 'price.type')));
                    }
                    if ($created) {
                        $added++;
                    } else {
                        $updated++;
                    }
                }
                if ($withdraw) {
                    $hidden = Property::where('sync_source', $source)->where('status', 1)
                        ->whereNotIn('sync_id', array_keys($seen))->update(['status' => 0]);
                }
                if ($apply) {
                    DB::commit();
                } else {
                    DB::rollBack();
                }
            } catch (Throwable $error) {
                DB::rollBack();
                throw $error;
            }
            $summary = sprintf('%s (%s): %d new, %d matched, %d withdrawn.', $apply ? 'Applied' : 'Preview', $source, $added, $updated, $hidden);
            $this->info($summary);
            if ($apply && $source === 'propertyfinder') {
                Cache::forever('pf-last-sync', ['time' => now()->utc()->toDateTimeString(), 'message' => $summary]);
            }
            Log::info($summary);
            return 0;
        } catch (Throwable $error) {
            // Database and HTTP exceptions can include listing data. Only expose our validation messages.
            $message = get_class($error) === RuntimeException::class ? $error->getMessage() : 'Import failed ('.class_basename($error).'). Check feed format, connectivity and migrations.';
            if ($apply && isset($source) && $source === 'propertyfinder') {
                Cache::forever('pf-last-sync', ['time' => now()->utc()->toDateTimeString(), 'message' => $message]);
            }
            $this->error($message);
            Log::error('Listing sync: '.$message);
            if (config('listing_sync.alert_email')) {
                Mail::raw($message, function ($mail) {
                    $mail->to(config('listing_sync.alert_email'))->subject('Elite Evolution listing sync failed');
                });
            }
            return 1;
        } finally {
            $lock->release();
        }
    }
}
