<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Property;
use App\Models\User;
use App\Support\MarketGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class GuideController extends Controller
{
    public function areas()
    {
        $listingCount = Property::where('status', 1)->count();

        return view('frontend.guides.areas', [
            'emirates' => $this->withCovers(MarketGuide::emirates()),
            'international' => $this->withCovers(MarketGuide::international()),
            'placeCount' => count(MarketGuide::places()),
            'listingCount' => $listingCount,
            'faqs' => [
                ['q' => 'How do I choose an area?', 'a' => 'Start with how you will use the home: weekdays, school runs, a view, or a hold of several years. The district follows that, not the other way around.'],
                ['q' => 'Do you cover every emirate?', 'a' => 'Dubai is where most of our stock sits. Other emirates and the international names in this guide are here because clients ask. If we cannot help properly, we say so.'],
                ['q' => 'Are the prices on these pages live asking prices?', 'a' => 'Medians are taken from the listings we have published. They are a guide to our current book, not a government index and not a valuation.'],
                ['q' => 'Can I look outside Dubai?', 'a' => 'Yes. Use the other emirates and international cards, then send the brief. We will tell you whether it is a search we should open.'],
            ],
        ]);
    }

    public function market(string $slug)
    {
        $market = MarketGuide::market($slug);
        abort_unless($market, 404);

        $query = MarketGuide::marketQuery($market);
        $places = [];
        foreach (MarketGuide::placesFor($slug) as $place) {
            $placeQuery = MarketGuide::placeQuery($place);
            $stats = MarketGuide::stats($placeQuery);
            $place['count'] = $stats['count'];
            $place['median'] = $stats['median'];
            $place['image'] = MarketGuide::cover($placeQuery, $place['slug']);
            $places[] = $place;
        }

        $known = array_map(function ($place) {
            return $place['name'];
        }, $places);

        if ($slug === 'dubai') {
            $extraNames = (clone $query)->whereNotNull('community')->distinct()->pluck('community');
            foreach ($extraNames as $name) {
                if (!$name || in_array($name, $known, true)) {
                    continue;
                }
                $already = false;
                foreach (MarketGuide::places() as $catalogued) {
                    if (in_array($name, $catalogued['match'], true)) {
                        $already = true;
                        break;
                    }
                }
                if ($already) {
                    continue;
                }
                $dynamic = [
                    'slug' => \Illuminate\Support\Str::slug($name),
                    'market' => $market['slug'],
                    'name' => $name,
                    'group' => null,
                    'match' => [$name],
                    'summary' => $name.' is a community we currently have on the books in '.$market['name'].'.',
                    'overview' => 'Listings in '.$name.' change with what owners and developers release. The homes on this page are the ones we can show you now.',
                    'infrastructure' => [],
                ];
                $placeQuery = MarketGuide::placeQuery($dynamic);
                $stats = MarketGuide::stats($placeQuery);
                $dynamic['count'] = $stats['count'];
                $dynamic['median'] = $stats['median'];
                $dynamic['image'] = MarketGuide::cover($placeQuery, $dynamic['slug']);
                $places[] = $dynamic;
            }
        }

        $developerIds = (clone $query)->whereNotNull('developer_id')->distinct()->pluck('developer_id');
        $developers = Developer::where('status', 1)->whereIn('id', $developerIds)->orderBy('name')->take(6)->get();
        $siblings = array_values(array_filter(
            $market['kind'] === 'international' ? MarketGuide::international() : MarketGuide::emirates(),
            function ($item) use ($slug) {
                return $item['slug'] !== $slug;
            }
        ));

        return view('frontend.guides.market', [
            'market' => $market,
            'places' => $places,
            'image' => MarketGuide::cover($query, $market['slug']),
            'stats' => MarketGuide::stats($query),
            'projects' => (clone $query)->with(['featuredImage', 'developer'])->latest()->take(6)->get(),
            'developers' => $developers,
            'siblings' => $this->withCovers(array_slice($siblings, 0, 4)),
            'faqs' => [
                ['q' => 'What can I buy in '.$market['name'].'?', 'a' => 'Whatever we have published for this market is on this page and in the listing search. Off-market homes are discussed after we know the brief.'],
                ['q' => 'How current are the figures?', 'a' => 'Counts and medians come from listings marked active on this site. A unit can go under offer without the public page updating the same hour.'],
                ['q' => 'Can you search only one community?', 'a' => 'Yes. Open a community card, or send us the name and we will narrow the book to it.'],
            ],
        ]);
    }

    public function place(string $marketSlug, string $placeSlug)
    {
        $market = MarketGuide::market($marketSlug);
        abort_unless($market, 404);

        $place = MarketGuide::place($placeSlug);
        if (!$place || $place['market'] !== $marketSlug) {
            $place = MarketGuide::placeFromInventory($market, $placeSlug);
        }
        abort_unless($place, 404);

        $query = MarketGuide::placeQuery($place);
        $offplan = $this->offplan(clone $query)->with(['featuredImage', 'developer'])->latest()->take(6)->get();
        $resale = $this->resale(clone $query)->with(['featuredImage', 'developer'])->latest()->take(6)->get();
        $developerIds = (clone $query)->whereNotNull('developer_id')->distinct()->pluck('developer_id');
        $agentIds = (clone $query)->whereNotNull('user_id')->distinct()->pluck('user_id');
        $pin = (clone $query)->whereNotNull('lat')->whereNotNull('lng')->first();
        $similar = array_values(array_filter(MarketGuide::placesFor($marketSlug), function ($item) use ($place) {
            if ($item['slug'] === $place['slug']) {
                return false;
            }
            if (!empty($place['group'])) {
                return $item['group'] === $place['group'];
            }

            return true;
        }));

        return view('frontend.guides.place', [
            'market' => $market,
            'place' => $place,
            'image' => MarketGuide::cover($query, $place['slug']),
            'stats' => MarketGuide::stats($query),
            'offplan' => $offplan,
            'resale' => $resale,
            'developers' => Developer::where('status', 1)->whereIn('id', $developerIds)->orderBy('name')->get(),
            'agents' => User::whereIn('id', $agentIds)->take(8)->get(),
            'mapQuery' => $pin ? $pin->lat.','.$pin->lng : $place['name'].', '.$market['name'],
            'similar' => $this->decoratePlaces(array_slice($similar, 0, 3)),
            'faqs' => [
                ['q' => 'Is '.$place['name'].' mainly off-plan or ready?', 'a' => 'Both appear when we have them. Use the two rows on this page, or the off-plan and resale links, to see which side of the book is active.'],
                ['q' => 'What should I check before offering?', 'a' => 'Service charges, the view you are actually buying, parking, and for off-plan the developer and the payment plan. We go through those with you before an offer.'],
                ['q' => 'Can I get a comparable price?', 'a' => 'The median here is only our published stock. A proper view of a unit needs the last sales we can stand behind, not a single average.'],
            ],
        ]);
    }

    public function developers(Request $request)
    {
        $developers = Developer::query()->where('status', 1)->withCount([
            'property as listings_count' => function ($query) {
                $query->where('status', 1);
            },
        ]);

        if ($request->filled('q')) {
            $developers->where('name', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('location')) {
            $location = $request->location;
            $developers->whereHas('property', function ($query) use ($location) {
                $query->where('status', 1)->where(function ($inner) use ($location) {
                    $inner->where('state', 'like', '%'.$location.'%')
                        ->orWhere('community', 'like', '%'.$location.'%')
                        ->orWhere('location', 'like', '%'.$location.'%');
                });
            });
        }

        $segment = $request->input('segment');
        $segmentNames = MarketGuide::segmentCommunities($segment);
        if ($segmentNames) {
            $developers->whereHas('property', function ($query) use ($segmentNames) {
                $query->where('status', 1)->where(function ($inner) use ($segmentNames) {
                    foreach ($segmentNames as $name) {
                        $inner->orWhere('community', $name);
                        if (strlen($name) >= 12) {
                            $inner->orWhere('community', 'like', '%'.$name.'%');
                        }
                    }
                });
            });
        }

        $developers = $developers->orderByDesc('listings_count')->orderBy('name')->get();
        $ids = $developers->pluck('id');
        $rows = $ids->isEmpty()
            ? collect()
            : Property::query()->where('status', 1)->whereIn('developer_id', $ids)->get(['developer_id', 'property_type', 'community']);

        $locations = Property::query()->where('status', 1)->whereNotNull('state')->where('state', '!=', '')->distinct()->orderBy('state')->pluck('state');

        return view('frontend.guides.developers', [
            'developers' => $developers,
            'meta' => $rows,
            'locations' => $locations,
            'listingCount' => Property::where('status', 1)->whereNotNull('developer_id')->count(),
            'communityCount' => Property::where('status', 1)->whereNotNull('community')->where('community', '!=', '')->distinct()->count('community'),
            'segments' => MarketGuide::groups(),
            'activeSegment' => $segmentNames ? $segment : null,
            'faqs' => [
                ['q' => 'How do you choose which developers to show?', 'a' => 'These are the developers on our books. A card does not mean every one of their projects is available through us.'],
                ['q' => 'Can you introduce me to a sales team?', 'a' => 'Yes, when we are instructed or the project is one we represent. Ask for the developer by name and we will say what we can open.'],
                ['q' => 'What if the developer I want is not listed?', 'a' => 'Send the name. If we do not cover them, we will tell you rather than force a different project.'],
            ],
        ]);
    }

    private function withCovers(array $markets): array
    {
        foreach ($markets as &$market) {
            $market['image'] = MarketGuide::cover(MarketGuide::marketQuery($market), $market['slug']);
        }

        return $markets;
    }

    private function decoratePlaces(array $places): array
    {
        foreach ($places as &$place) {
            $query = MarketGuide::placeQuery($place);
            $stats = MarketGuide::stats($query);
            $place['count'] = $stats['count'];
            $place['median'] = $stats['median'];
            $place['image'] = MarketGuide::cover($query, $place['slug']);
        }

        return $places;
    }

    private function offplan($query)
    {
        if (!Schema::hasColumn('properties', 'completion_status')) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function ($inner) {
            $inner->where('completion_status', 'Off-plan');
            if (Schema::hasColumn('properties', 'is_new_project')) {
                $inner->orWhere('is_new_project', 1);
            }
        });
    }

    private function resale($query)
    {
        $query->where(function ($inner) {
            $inner->where('type', 'sale')->orWhereNull('type');
        });

        if (Schema::hasColumn('properties', 'completion_status')) {
            $query->where(function ($inner) {
                $inner->whereNull('completion_status')
                    ->orWhere('completion_status', '!=', 'Off-plan');
            });
            if (Schema::hasColumn('properties', 'is_new_project')) {
                $query->where(function ($inner) {
                    $inner->whereNull('is_new_project')->orWhere('is_new_project', 0);
                });
            }
        }

        return $query;
    }
}
