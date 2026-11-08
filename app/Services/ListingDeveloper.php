<?php

namespace App\Services;

use App\Models\Developer;
use Illuminate\Support\Str;

class ListingDeveloper
{
    public static function resolve($name, array $location)
    {
        if (is_string($name) && trim($name) !== '') {
            $slug = Str::slug($name);
            if ($slug === 'damac-properties') {
                $slug = 'damac';
            }
            return Developer::where('slug', $slug)->orWhere('name', trim($name))->value('id');
        }

        // The Atlas listing can omit the developer while identifying the project.
        $projects = array_map(function ($value) {
            return Str::slug((string) $value);
        }, [$location['building'] ?? '', $location['name'] ?? '', $location['community'] ?? '']);
        if (array_intersect($projects, ['damac-islands', 'damac-islands-2', 'damac-bay-tower-c', 'chic-tower'])) {
            return Developer::where('slug', 'damac')->value('id');
        }

        return null;
    }
}
