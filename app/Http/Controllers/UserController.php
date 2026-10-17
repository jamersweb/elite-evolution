<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->get();
        return view('management.users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('management.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);





        $user = User::create($input);

        $token = Password::getRepository()->create($user);

//        $ff = $user->sendPasswordResetNotification($token);


        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::find($id);
        return view('management.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('management.users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }

    private function canEditStaffProfile()
    {
        return auth()->user()->hasRole(['agent', 'Agent', 'eliteagent', 'Admin', 'admin']);
    }

    public function Myprofile()
    {
        $data['languages'] = $this->getLanguageName();

        if ($this->canEditStaffProfile()) {
            return view('management.users.myprofile', $data);
        }
        return abort(403);
    }

    public function MyprofilePost(Request $request)
    {
        if (!$this->canEditStaffProfile()) {
            abort(403);
        }

        $this->validate($request, [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $area = is_array($request->area_tags) ? $request->area_tags : explode(',', $request->area_tags ?? '');
        $language = $request->language_multi_select != null ? json_encode($request->language_multi_select) : null;
        if ($request->file('image')) {
            $main_file = 'profile' . time() . rand(1000, 9999) . '.' . $request->file('image')->extension();
            $request->image->move(public_path('images/media/profile'), $main_file);
        } else {
            $main_file = auth()->user()->image;
        }
        $data = $request->only(['name', 'occupation', 'phone', 'whatsapp_no', 'brn', 'experience', 'nationality', 'linkedin_url', 'about']);
        $data['image'] = $main_file;
        $data['area_tags'] = json_encode(array_filter(array_map('trim', $area)));
        $data['language_multi_select'] = $language;

        User::whereId(auth()->user()->id)->first()
            ->update($data);
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function getLanguageName()
    {
        $jsonPath = public_path('language.json');
        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
            return json_decode($jsonContent, true) ?? [];
        }
        return ['English', 'Arabic', 'Russian', 'French', 'German', 'Spanish', 'Urdu', 'Hindi', 'Persian', 'Mandarin'];
    }


}
