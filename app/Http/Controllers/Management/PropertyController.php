<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Property;
use App\Models\media;
use App\Models\PropertyInquiry;
use App\Models\Amenities;
use App\Models\User;
use App\Models\Leads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:property-list', ['only' => ['index']]);
        $this->middleware('permission:property-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:property-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:property-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data['sale'] = Property::where('type', 'sale')->count();
        $data['rent'] = Property::where('type', 'rent')->count();
        $data['pending'] = Property::where('status', '!=', 1)->count();
        $query = Property::query();

        if (!auth()->user()->hasRole(['Admin', 'admin'])) {
            $query->where('user_id', auth()->user()->id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $minprice = $request->filled('min_price') ? (float)$request->min_price : 0;
            $maxprice = $request->filled('max_price') ? (float)$request->max_price : 9999999999;
            $query->whereBetween('price', [$minprice, $maxprice]);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('land_type', $request->category);
        }

        if ($request->filled('completion_status')) {
            $query->where('completion_status', $request->completion_status);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', $request->bedrooms);
        }

        if ($request->filled('furnishing_type')) {
            $query->where('furnishing_type', $request->furnishing_type);
        }

        if ($request->filled('agent_id')) {
            $query->where('user_id', $request->agent_id);
        }

        $data['property'] = $query->with(['user', 'developer'])->latest()->paginate(20);
        $data['agents'] = User::agents()->get();

        return view('management.property.index', $data);
    }

    public function create()
    {
        $data['amenities'] = Amenities::all();
        $data['developer'] = Developer::where('status', 1)->get();
        $data['agents'] = User::agents()->where('status', 'active')->get();

        return view('management.property.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'type' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        $data = $request->all();

        // Handle Brochure Upload
        if ($request->hasFile('brochure')) {
            $mainext = $request->file('brochure')->getClientOriginalExtension();
            $main_file_cover = 'brochure_' . time() . '_' . rand(1000, 9999) . '.' . $mainext;
            $request->brochure->move(public_path('images/media'), $main_file_cover);
            $data['brochure'] = $main_file_cover;
        }

        // Handle Madmoun QR Code Upload
        if ($request->hasFile('permit_qr_image')) {
            $qrext = $request->file('permit_qr_image')->getClientOriginalExtension();
            $qrFile = 'qr_' . time() . '_' . rand(1000, 9999) . '.' . $qrext;
            $request->permit_qr_image->move(public_path('images/media'), $qrFile);
            $data['permit_qr_image'] = $qrFile;
        }

        $data['amenities'] = $request->has('amenities') ? json_encode($request->amenities) : null;
        
        // Agent listing permission logic: Admin approval or auto-publish for admin
        if (auth()->user()->hasRole(['agent', 'Agent', 'eliteagent'])) {
            $data['status'] = 0; // Requires admin approval
            $data['user_id'] = auth()->user()->id;
        } else {
            $data['status'] = $request->input('status', 1);
            $data['user_id'] = $request->filled('user_id') ? $request->user_id : auth()->user()->id;
        }

        if ($request->filled('address2')) {
            $data['address'] = $request->address2;
        }

        if (empty($data['reference_no'])) {
            $data['reference_no'] = 'EERE-' . strtoupper(Str::random(3)) . '-' . rand(100, 999);
        }

        $property = Property::create($data);

        // Multiple Gallery Images
        $images = $request->file('image');
        if (isset($images)) {
            foreach ($images as $image) {
                $mainext = $image->getClientOriginalExtension();
                $main_file = 'property_' . time() . '_' . rand(1000, 9999) . '.' . $mainext;
                $image->move(public_path('images/media'), $main_file);
                media::create([
                    'reference_id' => $property->id,
                    'reference_type' => 'property',
                    'image' => $main_file,
                ]);
            }
        }

        return redirect()->route('property.index')->with('success', 'Property listing created successfully.');
    }

    public function show($id)
    {
        $property = Property::with(['developer', 'user', 'media'])->findOrFail($id);
        return view('management.property.show', compact('property'));
    }

    public function edit($id)
    {
        $data['developer'] = Developer::where('status', 1)->get();
        $data['property'] = Property::findOrFail($id);
        $data['amenities'] = Amenities::all();
        $data['media'] = media::where('reference_id', $id)->where('reference_type', 'property')->get();
        $data['agents'] = User::agents()->where('status', 'active')->get();

        return view('management.property.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('brochure')) {
            $mainext = $request->file('brochure')->getClientOriginalExtension();
            $main_file_cover = 'brochure_' . time() . '_' . rand(1000, 9999) . '.' . $mainext;
            $request->brochure->move(public_path('images/media'), $main_file_cover);
            $data['brochure'] = $main_file_cover;
        }

        if ($request->hasFile('permit_qr_image')) {
            $qrext = $request->file('permit_qr_image')->getClientOriginalExtension();
            $qrFile = 'qr_' . time() . '_' . rand(1000, 9999) . '.' . $qrext;
            $request->permit_qr_image->move(public_path('images/media'), $qrFile);
            $data['permit_qr_image'] = $qrFile;
        }

        $data['amenities'] = $request->has('amenities') ? json_encode($request->amenities) : null;

        if (!auth()->user()->hasRole(['Admin', 'admin'])) {
            unset($data['user_id']); // Agents cannot reassign ownership
        }

        $property->update($data);

        $images = $request->file('image');
        if (isset($images)) {
            foreach ($images as $image) {
                $mainext = $image->getClientOriginalExtension();
                $main_file = 'property_' . time() . '_' . rand(1000, 9999) . '.' . $mainext;
                $image->move(public_path('images/media'), $main_file);
                media::create([
                    'reference_id' => $id,
                    'reference_type' => 'property',
                    'image' => $main_file,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Property updated successfully.');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        media::where('reference_id', $id)->where('reference_type', 'property')->delete();
        $property->delete();

        return redirect()->route('property.index')->with('success', 'Property deleted successfully.');
    }

    public function imageDelete(Request $request)
    {
        media::where('id', $request->id)->delete();
        return response()->json(['success' => true]);
    }

    public function locationSearch(Request $request)
    {
        $query = $request->input('input', '');
        $properties = Property::where('completesearch', 'LIKE', "%{$query}%")
            ->orWhere('community', 'LIKE', "%{$query}%")
            ->orWhere('title', 'LIKE', "%{$query}%")
            ->pluck('completesearch')
            ->filter()
            ->unique()
            ->values();

        return response()->json($properties, 200);
    }

    public function CountrySwitcher($slug)
    {
        session()->put('country', $slug);
        return redirect()->back();
    }

    public function InquireBrochure(Request $request, $id)
    {
        // Anti-spam honeypot
        if ($request->filled('hp_email_verify')) {
            return redirect()->back();
        }

        $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $property = Property::findOrFail($id);

        PropertyInquiry::create([
            'property_id' => $id,
            'name' => $request->input('name', 'Interested Client'),
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => 'brochure',
            'assigned_agent_id' => $property->user_id,
        ]);

        // Also record as a Lead in CRM
        Leads::create([
            'firstname' => $request->name ?? 'Brochure Lead',
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => 'Brochure Download',
            'property_id' => $id,
            'assigned_agent_id' => $property->user_id,
            'status' => 'new',
        ]);

        if (!empty($property->brochure)) {
            $filePath = public_path('images/media/' . $property->brochure);
            if (file_exists($filePath)) {
                try {
                    Mail::send('email.brochure', ['property' => $property], function ($message) use ($filePath, $request, $property) {
                        $message->to($request->email)
                            ->subject('Your Brochure for ' . $property->title)
                            ->attach($filePath, ['as' => Str::slug($property->title) . '-brochure.pdf']);
                    });
                } catch (\Exception $e) {
                    \Log::error('Mail delivery failure: ' . $e->getMessage());
                }
            }
        }

        return redirect()->back()->with('success', 'Brochure requested! Please check your email inbox.');
    }

    public function BookViewing(Request $request, $id)
    {
        // Anti-spam honeypot
        if ($request->filled('hp_fax_check')) {
            return redirect()->back();
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'date' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        $property = Property::findOrFail($id);

        PropertyInquiry::create([
            'property_id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => 'Viewing Date requested: ' . $request->date . ' | Message: ' . $request->message,
            'type' => 'viewing',
            'assigned_agent_id' => $property->user_id,
            'status' => 'new',
        ]);

        Leads::create([
            'firstname' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => 'Viewing Request',
            'property_id' => $id,
            'assigned_agent_id' => $property->user_id,
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Viewing request submitted! Our licensed property advisor will contact you shortly.');
    }
}
