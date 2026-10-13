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

        $readyQuery = Property::with(['developer', 'user', 'featuredImage'])->where('status', 1);
        if (\Illuminate\Support\Facades\Schema::hasColumn('properties', 'completion_status')) {
            $readyQuery->where('completion_status', 'Ready');
        }
        $data['ready_properties'] = $readyQuery->latest()->take(4)->get();

        $offplanQuery = Property::with(['developer', 'user', 'featuredImage'])->where('status', 1);
        if (\Illuminate\Support\Facades\Schema::hasColumn('properties', 'completion_status')) {
            $offplanQuery->where(function($q) {
                $q->where('completion_status', 'Off-plan');
                if (\Illuminate\Support\Facades\Schema::hasColumn('properties', 'is_new_project')) {
                    $q->orWhere('is_new_project', 1);
                }
            });
        } elseif (\Illuminate\Support\Facades\Schema::hasColumn('properties', 'is_new_project')) {
            $offplanQuery->where('is_new_project', 1);
        }
        $data['offplan_projects'] = $offplanQuery->latest()->take(4)->get();

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

    public function AllAgents(Request $request)
    {
        $query = User::agents()->where('status', 'active');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'LIKE', "%{$s}%")
                  ->orWhere('occupation', 'LIKE', "%{$s}%")
                  ->orWhere('about', 'LIKE', "%{$s}%")
                  ->orWhere('area_tags', 'LIKE', "%{$s}%");
            });
        }

        if ($request->filled('area')) {
            $query->where('area_tags', 'LIKE', "%" . $request->area . "%");
        }

        if ($request->filled('language')) {
            $query->where('language_multi_select', 'LIKE', "%" . $request->language . "%");
        }

        $agents = $query->withCount(['properties as active_listings_count' => function ($q) {
                $q->where('status', 1);
            }])
            ->orderByRaw("CASE WHEN slug = 'graeme' OR name LIKE '%Graeme%' THEN 0 ELSE 1 END")
            ->latest('id')
            ->get();

        return view('frontend.agents.agents', [
            'agents' => $agents,
            'agent' => $agents,
        ]);
    }

    public function AgentsDetail($slug)
    {
        $hasSlug = \Illuminate\Support\Facades\Schema::hasColumn('users', 'slug');

        $agent = User::agents()
            ->where(function ($q) use ($slug, $hasSlug) {
                if ($hasSlug) {
                    $q->where('slug', $slug)
                      ->orWhere('slug', Str::slug($slug));
                }
                if (in_array(strtolower($slug), ['graeme', 'graeme-highlands'])) {
                    if ($hasSlug) {
                        $q->orWhere('slug', 'graeme')
                          ->orWhere('slug', 'graeme-highlands');
                    }
                    $q->orWhere('name', 'LIKE', '%Graeme%');
                }
            })
            ->first();

        if (!$agent) {
            if (in_array(strtolower($slug), ['graeme', 'graeme-highlands'])) {
                $agent = $this->getOrCreateGraeme();
            } else {
                abort(404);
            }
        }

        $properties = Property::with(['developer', 'featuredImage', 'media'])
            ->where('user_id', $agent->id)
            ->where('status', 1)
            ->latest()
            ->paginate(6);

        return view('frontend.agents.detail', compact('agent', 'properties'));
    }

    public function GraemeLanding(Request $request)
    {
        return $this->AgentsDetail('graeme');
    }

    public function DirectAgentProfile($slug)
    {
        $reserved = [
            'admin', 'adminpanel', 'login', 'register', 'password', 'logout', 'home',
            'terms-and-conditions', 'privacy-policy', 'cookies-policy', 'thank-you',
            'about-us', 'luxury-rentals', 'map-view', 'view', 'developer', 'blog',
            'appraise-your-property', 'sell-your-property', 'career', 'contact-us',
            'career-submit', 'listing', 'detail', 'agents', 'location-search', 'country',
            'api', 'my-account', 'wishlist', 'saved-search', 'newsletter', 'book-viewing',
            'inquire-brochure', 'post-like', 'post-dislike', 'update-password'
        ];

        if (in_array(strtolower($slug), $reserved)) {
            return response()->view('404', [], 404);
        }

        $hasSlug = \Illuminate\Support\Facades\Schema::hasColumn('users', 'slug');

        $agent = User::agents()
            ->where(function ($q) use ($slug, $hasSlug) {
                if ($hasSlug) {
                    $q->where('slug', $slug)
                      ->orWhere('slug', Str::slug($slug));
                }
                if (in_array(strtolower($slug), ['graeme', 'graeme-highlands'])) {
                    if ($hasSlug) {
                        $q->orWhere('slug', 'graeme')
                          ->orWhere('slug', 'graeme-highlands');
                    }
                    $q->orWhere('name', 'LIKE', '%Graeme%');
                }
            })
            ->first();

        if ($agent) {
            return $this->AgentsDetail($agent->slug ?? $slug);
        }

        return response()->view('404', [], 404);
    }

    public function AgentVCard($slug)
    {
        $agent = User::agents()
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                  ->orWhere('slug', Str::slug($slug));
                if (in_array(strtolower($slug), ['graeme', 'graeme-highlands'])) {
                    $q->orWhere('slug', 'graeme')
                      ->orWhere('slug', 'graeme-highlands')
                      ->orWhere('name', 'LIKE', '%Graeme%');
                }
            })
            ->first();

        if (!$agent) {
            if (in_array(strtolower($slug), ['graeme', 'graeme-highlands'])) {
                $agent = $this->getOrCreateGraeme();
            } else {
                abort(404);
            }
        }

        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:" . $agent->name . "\r\n";
        $vcard .= "N:" . $agent->name . ";;;;\r\n";
        $vcard .= "ORG:Elite Evolution Real Estate\r\n";
        if ($agent->occupation) {
            $vcard .= "TITLE:" . $agent->occupation . "\r\n";
        }
        if ($agent->phone) {
            $vcard .= "TEL;TYPE=WORK,VOICE:" . $agent->phone . "\r\n";
        }
        if ($agent->whatsapp_no) {
            $vcard .= "TEL;TYPE=CELL,VOICE:+" . preg_replace('/[^0-9]/', '', $agent->whatsapp_no) . "\r\n";
        }
        if ($agent->email) {
            $vcard .= "EMAIL;TYPE=WORK:" . $agent->email . "\r\n";
        }
        $vcard .= "URL:" . url('/' . $agent->slug) . "\r\n";
        $vcard .= "ADR;TYPE=WORK:;;Saeed Haseeb Building, Port Saeed, Deira;Dubai;;;United Arab Emirates\r\n";
        if ($agent->brn) {
            $vcard .= "NOTE:DLD Broker Registration (BRN) #" . $agent->brn . "\r\n";
        }
        $vcard .= "END:VCARD\r\n";

        $filename = Str::slug($agent->name) . '.vcf';

        return response($vcard, 200, [
            'Content-Type' => 'text/vcard; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function AgentInquire(Request $request, $slug)
    {
        // Anti-spam honeypot
        if ($request->filled('hp_contact_check')) {
            return redirect()->back();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'nullable|string',
            'property_id' => 'nullable|integer',
        ]);

        $agent = User::agents()
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)
                  ->orWhere('slug', Str::slug($slug));
                if (in_array(strtolower($slug), ['graeme', 'graeme-highlands'])) {
                    $q->orWhere('slug', 'graeme')
                      ->orWhere('slug', 'graeme-highlands')
                      ->orWhere('name', 'LIKE', '%Graeme%');
                }
            })
            ->first();

        if (!$agent) {
            if (in_array(strtolower($slug), ['graeme', 'graeme-highlands'])) {
                $agent = $this->getOrCreateGraeme();
            } else {
                abort(404);
            }
        }

        Leads::create([
            'firstname' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => 'Direct Agent Advisory: ' . $agent->name,
            'assigned_agent_id' => $agent->id,
            'property_id' => $request->property_id,
            'status' => 'new',
        ]);

        PropertyInquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message ?? ('Advisory request with ' . $agent->name),
            'type' => 'agent_consultation',
            'assigned_agent_id' => $agent->id,
            'property_id' => $request->property_id,
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Your inquiry has been sent directly to ' . $agent->name . '. You will receive a response shortly.');
    }

    private function getOrCreateGraeme()
    {
        $graeme = User::where('email', 'graeme@eliteevolutionrealestate.ae');
        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'slug')) {
            $graeme->orWhere('slug', 'graeme');
        }
        $graeme = $graeme->orWhere('name', 'LIKE', '%Graeme%')->first();

        if (!$graeme) {
            $createData = [
                'name' => 'Graeme Highlands',
                'email' => 'graeme@eliteevolutionrealestate.ae',
                'password' => bcrypt('password123'),
                'phone' => '+971 56 970 0771',
            ];
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'slug')) $createData['slug'] = 'graeme';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'whatsapp_no')) $createData['whatsapp_no'] = '971569700771';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'brn')) $createData['brn'] = '78334';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'experience')) $createData['experience'] = '8+ Years in Prime Dubai Real Estate';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'occupation')) $createData['occupation'] = 'Senior Luxury Property Advisor';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'about')) $createData['about'] = 'Specializing in ultra-prime residential assets, waterfront villas in Palm Jumeirah, and bespoke off-plan investments across Dubai\'s most coveted communities including DAMAC Lagoons and Emirates Hills. Graeme delivers discreet, institutional-grade advisory for private clients and international family offices.';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'language_multi_select')) $createData['language_multi_select'] = json_encode(['English', 'French']);
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'area_tags')) $createData['area_tags'] = json_encode(['Palm Jumeirah', 'DAMAC Lagoons', 'Dubai Marina', 'Emirates Hills']);
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'nationality')) $createData['nationality'] = 'British';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'image')) $createData['image'] = 'graeme.jpg';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'status')) $createData['status'] = 'active';
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'is_agent')) $createData['is_agent'] = true;

            $graeme = User::create($createData);

            if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
                try {
                    $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'agent', 'guard_name' => 'web']);
                    $graeme->assignRole($role);
                } catch (\Throwable $e) {
                    // Role table not populated, safely proceed
                }
            }
        }

        return $graeme;
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
