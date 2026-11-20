<?php

namespace App\Support;

use App\Models\Property;
use Illuminate\Support\Str;

class MarketGuide
{
    public static function groups(): array
    {
        return config('market_guides.groups', []);
    }

    public static function markets(): array
    {
        $markets = [];
        foreach (config('market_guides.markets', []) as $slug => $market) {
            $market['slug'] = $slug;
            $markets[$slug] = $market;
        }

        return $markets;
    }

    public static function places(): array
    {
        $places = [];
        foreach (config('market_guides.places', []) as $slug => $place) {
            $place['slug'] = $slug;
            $place['match'] = $place['match'] ?? [$place['name']];
            $places[$slug] = $place;
        }

        return $places;
    }

    public static function market(string $slug): ?array
    {
        return self::markets()[$slug] ?? null;
    }

    public static function place(string $slug): ?array
    {
        return self::places()[$slug] ?? null;
    }

    public static function placesFor(string $marketSlug): array
    {
        return array_values(array_filter(self::places(), function ($place) use ($marketSlug) {
            return $place['market'] === $marketSlug;
        }));
    }

    public static function groupLabel(?string $key): ?string
    {
        foreach (self::groups() as $group) {
            if ($group['key'] === $key) {
                return $group['label'];
            }
        }

        return null;
    }

    public static function trending(): ?array
    {
        $slug = config('market_guides.trending');

        return $slug ? self::place($slug) : null;
    }

    public static function emirates(): array
    {
        return array_values(array_filter(self::markets(), function ($market) {
            return $market['kind'] === 'emirate';
        }));
    }

    public static function otherEmirates(): array
    {
        return array_values(array_filter(self::emirates(), function ($market) {
            return $market['slug'] !== 'dubai';
        }));
    }

    public static function international(): array
    {
        return array_values(array_filter(self::markets(), function ($market) {
            return $market['kind'] === 'international';
        }));
    }

    public static function marketUrl(string $slug): string
    {
        return url('areas/'.$slug);
    }

    public static function placeUrl(array $place): string
    {
        return url('areas/'.$place['market'].'/'.$place['slug']);
    }

    public static function placeQuery(array $place)
    {
        $names = $place['match'] ?? [$place['name']];

        return Property::query()->where('status', 1)->where(function ($query) use ($names) {
            foreach ($names as $name) {
                $query->orWhere('community', $name)->orWhere('sub_community', $name);
                if (strlen($name) >= 12) {
                    $query->orWhere('community', 'like', '%'.$name.'%')
                        ->orWhere('location', 'like', '%'.$name.'%')
                        ->orWhere('completesearch', 'like', '%'.$name.'%');
                }
            }
        });
    }

    public static function marketQuery(array $market)
    {
        return Property::query()->where('status', 1)->where(function ($query) use ($market) {
            $name = $market['name'];
            $query->where('state', 'like', '%'.$name.'%')
                ->orWhere('location', 'like', '%'.$name.'%')
                ->orWhere('completesearch', 'like', '%'.$name.'%');

            if ($market['kind'] === 'emirate' && strcasecmp($name, 'Dubai') === 0) {
                $query->orWhere(function ($dubai) {
                    $dubai->where(function ($country) {
                        $country->where('country', 'like', '%uae%')
                            ->orWhere('country', 'like', '%dubai%')
                            ->orWhereNull('country')
                            ->orWhere('country', '');
                    })->where(function ($state) {
                        $state->whereNull('state')
                            ->orWhere('state', '')
                            ->orWhere('state', 'like', '%dubai%');
                    });
                });
            }

            foreach (self::placesFor($market['slug']) as $place) {
                foreach ($place['match'] as $match) {
                    $query->orWhere('community', $match);
                }
            }
        });
    }

    public static function stats($query): array
    {
        $rows = (clone $query)->get(['price', 'developer_id']);
        $prices = $rows->pluck('price')->filter(function ($price) {
            return (float) $price > 0;
        })->sort()->values();
        $count = $prices->count();
        $median = null;
        if ($count) {
            $mid = intdiv($count, 2);
            $median = $count % 2
                ? (float) $prices[$mid]
                : ((float) $prices[$mid - 1] + (float) $prices[$mid]) / 2;
        }

        return [
            'count' => $rows->count(),
            'median' => $median,
            'developers' => $rows->pluck('developer_id')->filter()->unique()->count(),
        ];
    }

    public static function cover($query, string $key): string
    {
        $property = (clone $query)->with('featuredImage')->latest('id')->limit(8)->get()
            ->first(function ($item) {
                return $item->featuredImage && $item->featuredImage->image;
            });

        if ($property) {
            return $property->featuredImage->display_url;
        }

        $fallbacks = [
            'frontend/img/banner_update.jpg',
            'frontend/img/sell_with_us.jpeg',
            'frontend/img/Luxury-house-exterior 1 (1).png',
            'frontend/img/banner.png',
        ];

        return asset($fallbacks[abs(crc32($key)) % count($fallbacks)]);
    }

    public static function money($amount): ?string
    {
        $amount = (float) $amount;
        if ($amount <= 0) {
            return null;
        }
        if ($amount >= 1000000) {
            $millions = $amount / 1000000;
            $formatted = number_format($millions, $millions >= 10 ? 0 : 1);

            return 'AED '.rtrim(rtrim($formatted, '0'), '.').'M';
        }

        return 'AED '.number_format($amount);
    }

    public static function placeFromInventory(array $market, string $slug): ?array
    {
        $names = Property::query()->where('status', 1)->whereNotNull('community')->distinct()->pluck('community');
        $name = $names->first(function ($community) use ($slug) {
            return Str::slug($community) === $slug;
        });

        if (!$name || isset(self::places()[$slug])) {
            return null;
        }

        if ($market['slug'] !== 'dubai') {
            $belongs = Property::query()->where('status', 1)->where('community', $name)->where(function ($query) use ($market) {
                $query->where('state', 'like', '%'.$market['name'].'%')
                    ->orWhere('location', 'like', '%'.$market['name'].'%')
                    ->orWhere('country', 'like', '%'.$market['name'].'%');
            })->exists();
            if (!$belongs) {
                return null;
            }
        }

        return [
            'slug' => $slug,
            'market' => $market['slug'],
            'name' => $name,
            'group' => null,
            'match' => [$name],
            'summary' => $name.' is a community we currently have on the books in '.$market['name'].'.',
            'overview' => 'Listings in '.$name.' change with what owners and developers release. The cards on this page are the homes we can show you now. For anything off-market, ask an advisor who covers '.$market['name'].'.',
            'infrastructure' => [],
        ];
    }

    public static function segmentCommunities(?string $segment): array
    {
        foreach (self::groups() as $group) {
            if ($group['key'] !== $segment) {
                continue;
            }
            $names = [];
            foreach ($group['places'] as $slug) {
                $place = self::place($slug);
                if ($place) {
                    $names = array_merge($names, $place['match']);
                }
            }

            return $names;
        }

        return [];
    }
}
