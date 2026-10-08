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
        $agents = User::agents()
            ->withCount(['properties as active_properties_count' => function ($query) {
                $query->where('status', 1);
            }])
            ->latest()
            ->paginate(15);

        return view('management.agents.index', compact('agents'));
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string',
            'whatsapp_no' => 'nullable|string',
            'brn' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except(['image', 'password', 'roles', 'area_tags', 'language_multi_select']);
        $data['password'] = Hash::make($request->password);
        $data['is_agent'] = true;
        $data['status'] = $request->input('status', 'active');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $imageName = 'agent_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $request->file('image')->move(public_path('images/media/profile'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->has('area_tags')) {
            $areas = is_array($request->area_tags) ? $request->area_tags : array_map('trim', explode(',', $request->area_tags));
            $data['area_tags'] = json_encode($areas);
        }

        if ($request->has('language_multi_select')) {
            $data['language_multi_select'] = json_encode($request->language_multi_select);
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

        return redirect()->route('agents.index')->with('success', 'Licensed Agent created successfully.');
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
        return view('management.agents.edit', compact('agent', 'roles', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $agent = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string',
            'whatsapp_no' => 'nullable|string',
            'brn' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except(['image', 'password', 'roles', 'area_tags', 'language_multi_select']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $imageName = 'agent_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $request->file('image')->move(public_path('images/media/profile'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->has('area_tags')) {
            $areas = is_array($request->area_tags) ? $request->area_tags : array_map('trim', explode(',', $request->area_tags));
            $data['area_tags'] = json_encode($areas);
        }

        if ($request->has('language_multi_select')) {
            $data['language_multi_select'] = json_encode($request->language_multi_select);
        }

        $agent->update($data);

        if ($request->filled('role')) {
            $agent->syncRoles([$request->role]);
        }

        return redirect()->route('agents.index')->with('success', 'Agent details updated successfully.');
    }

    public function destroy($id)
    {
        $agent = User::findOrFail($id);
        $agent->delete();

        return redirect()->route('agents.index')->with('success', 'Agent profile removed.');
    }

    private function getLanguages()
    {
        $path = public_path('language.json');
        if (file_exists($path)) {
            $json = json_decode(file_get_contents($path), true);
            return $json ?? [];
        }
        return ['English', 'Arabic', 'Russian', 'French', 'German', 'Spanish', 'Urdu', 'Hindi', 'Persian', 'Mandarin'];
    }
}
