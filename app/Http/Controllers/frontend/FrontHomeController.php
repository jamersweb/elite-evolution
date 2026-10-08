<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Searches;
use App\Models\Property;
use App\Models\User;
use App\Models\blog;
use App\Models\Newsletter;
use App\Models\Leads;
use App\Models\PropertyInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FrontHomeController extends Controller
{
    public function index(Request $request)
    {
        $country = session('country', 'United Arab Emirates');
        if ($country == 'uae') {
            $country = 'United Arab Emirates';
        } elseif ($country == 'uk') {
            $country = 'United Kingdom';
        }

        $properties = Property::where('status', 1)
            ->where('country', $country)
            ->where('type', 'sale')
            ->whereNotNull('state')
            ->groupBy('state')
            ->pluck('state');

        $data['state'] = [];
        foreach ($properties as $prop) {
            $count = Property::where('status', 1)
                ->where('country', $country)
                ->where('state', $prop)
                ->count();

            if ($count > 0) {
                $imageProp = Property::where('status', 1)
                    ->where('state', $prop)
                    ->where('country', $country)
                    ->first();

                $featuredImg = $imageProp && $imageProp->featuredImage ? $imageProp->featuredImage->image : null;
                $data['state'][] = [
                    'count' => $count,
                    'image' => $featuredImg,
                    'name' => $prop,
                ];
            }
        }

        $data['featured_properties'] = Property::with(['developer', 'user', 'featuredImage', 'media'])
            ->where('status', 1)
            ->latest()
            ->take(6)
            ->get();

        $data['ready_properties'] = Property::with(['developer', 'user', 'featuredImage'])
            ->where('status', 1)
            ->where('completion_status', 'Ready')
            ->latest()
            ->take(4)
            ->get();

        $data['offplan_projects'] = Property::with(['developer', 'user', 'featuredImage'])
            ->where('status', 1)
            ->where(function($q) {
                $q->where('completion_status', 'Off-plan')->orWhere('is_new_project', 1);
            })
            ->latest()
            ->take(4)
            ->get();

        $data['luxury_rentals'] = Property::with(['developer', 'user', 'featuredImage'])
            ->where('status', 1)
            ->where('type', 'rent')
            ->latest()
            ->take(4)
            ->get();

        $data['developers'] = Developer::where('status', 1)->take(8)->get();
        $data['agent'] = User::agents()->where('status', 'active')->take(6)->get();

        $data['blogs'] = blog::where('status', 1)->latest()->take(3)->get();

        return view('frontend.home.index', $data);
    }

    public function Developer($slug)
    {
        $developer = Developer::whereSlug($slug)->firstOrFail();
        $properties = Property::where('developer_id', $developer->id)->where('status', 1)->latest()->paginate(9);
        return view('frontend.developers.show', compact('developer', 'properties'));
    }

    public function DeveloperProperty($slug, $propertySlug)
    {
        $developer = Developer::whereSlug($slug)->firstOrFail();
        $property = Property::with(['developer', 'user', 'media'])->whereSlug($propertySlug)->firstOrFail();
        return view('frontend.developers.property-detail', compact('developer', 'property'));
    }

    public function About()
    {
        return view('frontend.about.index');
    }

    public function blog()
    {
        return view('frontend.blog.index');
    }

    public function post()
    {
        $blogs = blog::where('status', 1)->latest()->paginate(9);
        return view('frontend.post.index', compact('blogs'));
    }

    public function SinglePost($slug)
    {
        $blog = blog::where('status', 1)->where('slug', $slug)->firstOrFail();
        $latest_blogs = blog::where('status', 1)->where('id', '!=', $blog->id)->latest()->take(4)->get();
        return view('frontend.post.show', compact('blog', 'latest_blogs'));
    }

    public function Listing(Request $request, $slug = 'all')
    {
        $country = session('country', 'United Arab Emirates');
        if ($country == 'uae') {
            $country = 'United Arab Emirates';
        }

        // AJAX search saving for authenticated users
        if ($request->ajax() && $request->tracking) {
            if (auth()->check()) {
                $searchData = $request->all();
                $searchData['user_id'] = auth()->id();
                $searchData['collection'] = $slug;
                Searches::create($searchData);
                return response()->json(['success' => true]);
            }
            return response()->json(['auth' => false]);
        }

        $query = Property::with(['developer', 'user', 'featuredImage', 'media'])
            ->where('status', 1);

        if ($country) {
            $query->where('country', $country);
        }

        // Purpose / Collection slug handling
        if ($slug == 'sale' || $slug == 'buy') {
            $query->where('type', 'sale');
        } elseif ($slug == 'ready' || $slug == 'buy-ready') {
            $query->where('type', 'sale')->where('completion_status', 'Ready');
        } elseif ($slug == 'off-plan' || $slug == 'offplan' || $slug == 'buy-offplan') {
            $query->where('type', 'sale')->where(function($q) {
                $q->where('completion_status', 'Off-plan')->orWhere('is_new_project', 1);
            });
        } elseif ($slug == 'rent' || $slug == 'luxury-rentals') {
            $query->where('type', 'rent');
        } elseif (in_array($slug, ['commercial', 'residential'])) {
            $query->where('land_type', $slug);
        }

        // Filters
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('completion_status')) {
            $query->where('completion_status', $request->completion_status);
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('location')) {
            $loc = $request->location;
            $query->where(function($q) use ($loc) {
                $q->where('community', 'LIKE', "%{$loc}%")
                  ->orWhere('sub_community', 'LIKE', "%{$loc}%")
                  ->orWhere('building', 'LIKE', "%{$loc}%")
                  ->orWhere('completesearch', 'LIKE', "%{$loc}%")
                  ->orWhere('address', 'LIKE', "%{$loc}%");
            });
        }

        if ($request->filled('bedrooms')) {
            if ($request->bedrooms == '6+' || $request->bedrooms == '7+') {
                $query->where('bedrooms', '>=', 6);
            } else {
                $query->where('bedrooms', $request->bedrooms);
            }
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', (int)$request->bathrooms);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float)$request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float)$request->max_price);
        }

        if ($request->filled('furnishing')) {
            $query->where('furnishing_type', $request->furnishing);
        }

        if ($request->filled('agent')) {
            $agent = User::where('slug', $request->agent)->first();
            if ($agent) {
                $query->where('user_id', $agent->id);
            }
        }

        if ($request->filled('developer')) {
            $dev = Developer::where('slug', $request->developer)->first();
            if ($dev) {
                $query->where('developer_id', $dev->id);
            }
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        if ($sort == 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $properties = $query->paginate(12)->withQueryString();

        // Purpose-aware page title & meta
        $pageTitle = 'Properties in Dubai';
        $pageSubtitle = 'Explore verified luxury properties for sale and rent';
        if ($slug == 'ready' || $slug == 'buy-ready') {
            $pageTitle = 'Ready Properties for Sale in Dubai';
            $pageSubtitle = 'Move-in ready luxury villas, penthouses and apartments';
        } elseif ($slug == 'off-plan' || $slug == 'offplan') {
            $pageTitle = 'Off-Plan Projects in Dubai';
            $pageSubtitle = 'Prime off-plan developments and investment opportunities';
        } elseif ($slug == 'rent' || $slug == 'luxury-rentals') {
            $pageTitle = 'Luxury Properties for Rent in Dubai';
            $pageSubtitle = 'Exclusive high-end rentals in Dubai’s prestigious addresses';
        }

        return view('frontend.property.index', [
            'property' => $properties,
            'slug' => $slug,
            'pageTitle' => $pageTitle,
            'pageSubtitle' => $pageSubtitle,
        ]);
    }

    public function LuxuryRentals(Request $request)
    {
        return $this->Listing($request, 'luxury-rentals');
    }

    public function MapView(Request $request)
    {
        $properties = Property::with(['developer', 'user', 'featuredImage'])
            ->where('status', 1)
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get();

        return view('frontend.property.map', compact('properties'));
    }

    public function PropertyDetail($slug)
    {
        $property = Property::with(['developer', 'user', 'media'])
            ->whereSlug($slug)
            ->firstOrFail();

        // Real similar listings in same community or property type
        $similar_properties = Property::with(['featuredImage', 'user'])
            ->where('status', 1)
            ->where('id', '!=', $property->id)
            ->where(function ($q) use ($property) {
                if ($property->community) {
                    $q->where('community', $property->community);
                }
                $q->orWhere('property_type', $property->property_type)
                  ->orWhere('type', $property->type);
            })
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.property.detail', [
            'property' => $property,
            'similar_properties' => $similar_properties,
            'meta_title' => $property->meta_title ?: "{$property->title} | Elite Evolution Real Estate",
            'meta_description' => $property->meta_description ?: Str::limit(strip_tags($property->description), 160),
        ]);
    }

    public function AllAgents()
    {
        $agents = User::agents()
            ->where('status', 'active')
            ->withCount(['properties as active_listings_count' => function ($q) {
                $q->where('status', 1);
            }])
            ->get();

        return view('frontend.agents.agents', [
            'agents' => $agents,
            'agent' => $agents,
        ]);
    }

    public function AgentsDetail($slug)
    {
        $agent = User::agents()
            ->where('slug', $slug)
            ->firstOrFail();

        $properties = Property::with(['developer', 'featuredImage'])
            ->where('user_id', $agent->id)
            ->where('status', 1)
            ->latest()
            ->paginate(6);

        return view('frontend.agents.detail', compact('agent', 'properties'));
    }

    public function Newsletter(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $existing = Newsletter::where('email', $request->email)->first();
        if (!$existing) {
            Newsletter::create(['email' => $request->email]);
            return response()->json(['success' => true, 'message' => 'Subscribed successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Email already subscribed.']);
    }

    /**
     * AI Concierge Assistant API
     * Provides conversational answers regarding listings, company, and DLD buying/renting process
     * Automatically captures leads into the CRM
     */
    public function ConciergeChat(Request $request)
    {
        $message = trim($request->input('message', ''));
        $sessionId = $request->input('session_id', Str::random(16));
        $contact = $request->input('contact', []); // ['name' => ..., 'email' => ..., 'phone' => ...]

        if (empty($message)) {
            return response()->json(['reply' => 'How can I assist you with Dubai real estate today?']);
        }

        // Capture lead if contact details were passed
        if (!empty($contact['phone']) || !empty($contact['email'])) {
            Leads::create([
                'firstname' => $contact['name'] ?? 'AI Concierge Visitor',
                'email' => $contact['email'] ?? null,
                'phone' => $contact['phone'] ?? null,
                'source' => 'AI Website Concierge',
                'status' => 'new',
            ]);
        }

        $lowerMsg = strtolower($message);

        // Intelligent keyword matching on live listings
        if (str_contains($lowerMsg, 'palm') || str_contains($lowerMsg, 'villa') || str_contains($lowerMsg, 'penthouse') || str_contains($lowerMsg, 'rent') || str_contains($lowerMsg, 'buy') || str_contains($lowerMsg, 'off-plan') || str_contains($lowerMsg, 'ready')) {
            $query = Property::with(['featuredImage'])->where('status', 1);
            if (str_contains($lowerMsg, 'rent')) {
                $query->where('type', 'rent');
            } elseif (str_contains($lowerMsg, 'buy') || str_contains($lowerMsg, 'sale')) {
                $query->where('type', 'sale');
            }
            if (str_contains($lowerMsg, 'palm')) {
                $query->where('community', 'LIKE', '%Palm%');
            }
            if (str_contains($lowerMsg, 'villa')) {
                $query->where('property_type', 'Villa');
            }
            if (str_contains($lowerMsg, 'ready')) {
                $query->where('completion_status', 'Ready');
            }

            $matches = $query->take(3)->get();
            if ($matches->count() > 0) {
                $reply = "Here are matching luxury properties from our live inventory:\n";
                foreach ($matches as $m) {
                    $priceText = $m->type == 'rent' ? 'AED ' . number_format($m->yearly_rent ?: $m->price) . '/year' : 'AED ' . number_format($m->price);
                    $reply .= "• **{$m->title}** ({$m->community}, {$m->bedrooms} Beds) - {$priceText}. [View Listing](" . url('/detail/' . $m->slug) . ")\n";
                }
                $reply .= "\nWould you like me to connect you directly with the licensed listing agent on WhatsApp or arrange a private viewing?";
                return response()->json(['reply' => $reply, 'properties' => $matches]);
            }
        }

        // FAQs: Buying Process, Golden Visa, Trakheesi & Permits
        if (str_contains($lowerMsg, 'visa') || str_contains($lowerMsg, 'golden')) {
            return response()->json([
                'reply' => "In Dubai, property investment of AED 2,000,000 or above qualifies eligible buyers for a 10-year UAE Golden Visa. Our licensed advisors at Elite Evolution can guide you through certified properties and the DLD registration process. May I take your WhatsApp number for a consultation?"
            ]);
        }

        if (str_contains($lowerMsg, 'permit') || str_contains($lowerMsg, 'madmoun') || str_contains($lowerMsg, 'trakheesi')) {
            return response()->json([
                'reply' => "All advertisements at Elite Evolution Real Estate are certified by the Dubai Land Department (DLD) with official Trakheesi permits and Madmoun verification QR codes, guaranteeing authentic and legal inventory."
            ]);
        }

        if (str_contains($lowerMsg, 'viewing') || str_contains($lowerMsg, 'book') || str_contains($lowerMsg, 'visit')) {
            return response()->json([
                'reply' => "I'd be delighted to arrange a private viewing for you. Please share your preferred date and contact number, or click the WhatsApp button to connect directly with our brokerage team."
            ]);
        }

        return response()->json([
            'reply' => "Welcome to Elite Evolution Real Estate. We represent prime ready villas, exclusive off-plan developments, and luxury rentals across Dubai (Palm Jumeirah, Emirates Hills, Jumeirah Islands, Downtown). How can I assist your search today, or would you like to speak directly with an advisor?"
        ]);
    }
}
