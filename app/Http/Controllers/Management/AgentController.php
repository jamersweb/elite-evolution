<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = User::agents()
            ->withCount(['properties as active_properties_count' => function ($q) {
                $q->where('status', 1);
            }]);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'LIKE', "%{$s}%")
                  ->orWhere('email', 'LIKE', "%{$s}%")
                  ->orWhere('brn', 'LIKE', "%{$s}%")
                  ->orWhere('occupation', 'LIKE', "%{$s}%")
                  ->orWhere('slug', 'LIKE', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $agents = $query->orderByRaw("CASE WHEN slug = 'graeme' OR name LIKE '%Graeme%' THEN 0 ELSE 1 END")
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total_agents' => User::agents()->count(),
            'active_agents' => User::agents()->where('status', 'active')->count(),
            'total_listings' => Property::where('status', 1)->whereNotNull('user_id')->count(),
        ];

        return view('management.agents.index', compact('agents', 'stats'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $languages = $this->getLanguages();
        return view('management.agents.create', compact('roles', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:users,slug',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string',
            'whatsapp_no' => 'nullable|string',
            'brn' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:100',
            'linkedin_url' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except(['image', 'password', 'roles', 'area_tags', 'language_multi_select']);
        $data['password'] = Hash::make($request->password);
        $data['is_agent'] = true;
        $data['status'] = $request->input('status', 'active');
        $data['slug'] = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);

        if ($request->hasFile('image')) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $imageName = 'agent_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $request->file('image')->move(public_path('images/media/profile'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->has('area_tags')) {
            $areas = is_array($request->area_tags) ? $request->area_tags : array_map('trim', explode(',', $request->area_tags));
            $areas = array_filter($areas);
            $data['area_tags'] = json_encode(array_values($areas));
        }

        if ($request->has('language_multi_select')) {
            $data['language_multi_select'] = json_encode(array_values((array)$request->language_multi_select));
        }

        $agent = User::create($data);

        // Assign agent role
        $roleName = $request->input('role', 'agent');
        if (Role::where('name', $roleName)->exists()) {
            $agent->assignRole($roleName);
        } else {
            $role = Role::firstOrCreate(['name' => 'agent', 'guard_name' => 'web']);
            $agent->assignRole($role);
        }

        return redirect()->route('agents.index')->with('success', 'Licensed Agent "' . $agent->name . '" created successfully. Live URL: ' . url('/' . $agent->slug));
    }

    public function show($id)
    {
        $agent = User::findOrFail($id);
        $properties = Property::where('user_id', $id)->latest()->paginate(10);
        return view('management.agents.show', compact('agent', 'properties'));
    }

    public function edit($id)
    {
        $agent = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $languages = $this->getLanguages();
        $propertiesCount = Property::where('user_id', $id)->count();
        return view('management.agents.edit', compact('agent', 'roles', 'languages', 'propertiesCount'));
    }

    public function update(Request $request, $id)
    {
        $agent = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:users,slug,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string',
            'whatsapp_no' => 'nullable|string',
            'brn' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:100',
            'linkedin_url' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except(['image', 'password', 'roles', 'area_tags', 'language_multi_select', 'remove_image']);
        $data['is_agent'] = true;
        $data['status'] = $request->input('status', 'active');

        if ($request->filled('slug')) {
            $data['slug'] = Str::slug($request->slug);
        } elseif ($request->filled('name') && empty($agent->slug)) {
            $data['slug'] = Str::slug($request->name);
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->has('remove_image') && $request->remove_image == 1) {
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $imageName = 'agent_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $request->file('image')->move(public_path('images/media/profile'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->has('area_tags')) {
            $areas = is_array($request->area_tags) ? $request->area_tags : array_map('trim', explode(',', $request->area_tags));
            $areas = array_filter($areas);
            $data['area_tags'] = json_encode(array_values($areas));
        }

        if ($request->has('language_multi_select')) {
            $data['language_multi_select'] = json_encode(array_values((array)$request->language_multi_select));
        }

        $agent->update($data);

        if ($request->filled('role')) {
            $agent->syncRoles([$request->role]);
        }

        return redirect()->route('agents.index')->with('success', 'Agent details for "' . $agent->name . '" updated successfully. Changes are immediately live on the frontend at ' . url('/' . $agent->slug));
    }

    public function destroy($id)
    {
        $agent = User::findOrFail($id);
        $name = $agent->name;
        $agent->delete();

        return redirect()->route('agents.index')->with('success', 'Agent profile for "' . $name . '" removed.');
    }

    private function getLanguages()
    {
        $path = public_path('language.json');
        if (file_exists($path)) {
            $json = json_decode(file_get_contents($path), true);
            if (is_array($json)) {
                $languages = [];
                foreach ($json as $item) {
                    if (is_array($item) && isset($item['English'])) {
                        $languages[] = $item['English'];
                    } elseif (is_string($item)) {
                        $languages[] = $item;
                    }
                }
                if (!empty($languages)) {
                    sort($languages);
                    return $languages;
                }
            }
        }
        return ['English', 'Arabic', 'Russian', 'French', 'German', 'Spanish', 'Urdu', 'Hindi', 'Persian', 'Mandarin', 'Italian'];
    }
}
