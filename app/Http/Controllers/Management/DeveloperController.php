<?php

namespace App\Http\Controllers\Management;
use App\Http\Controllers\Controller;

use App\Models\Developer;
use App\Models\Property;
use App\Models\media;
use App\Models\Amenities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:property-list', ['only' => ['index']]);
        $this->middleware('permission:property-create', ['only' => ['create','store']]);
        $this->middleware('permission:property-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:property-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $data['developer']= Developer::get();
        return view('management.developers.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.developers.create');
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
            'status' => 'required',
        ]);





        $data = $request->all();

        if ($request->file('image')) {
            $mainext = $request->file('image')->getClientOriginalExtension();
            $main_file = 'developers'.time() . rand(1000, 14000000000) . '.' . $mainext;
            $request->image->move(public_path('images/media/developers'), $main_file);
        }else{
            $main_file = null;
        }
        if ($request->file('cover')) {
            $mainext = $request->file('cover')->getClientOriginalExtension();
            $main_file_cover = 'developers-cover'.time() . rand(1000, 14000000000) . '.' . $mainext;
            $request->cover->move(public_path('images/media/developers'), $main_file_cover);
        }else{
            $main_file_cover = null;
        }
        $data['image'] = $main_file;
        $data['cover'] = $main_file_cover;
        $data['user_id'] = auth()->user()->id;
        $property = Developer::create($data);
        return redirect()->back()->with('success','Developer created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function show(Permissions $permissions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['developer'] = Developer::findorfail($id);
        return view('management.developers.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        $developer = Developer::findorfail($id);
        $data = $request->all();

        if ($request->file('image')) {
            $mainext = $request->file('image')->getClientOriginalExtension();
            $main_file = 'developers'.time() . rand(1000, 14000000000) . '.' . $mainext;
            $request->image->move(public_path('images/media/developers'), $main_file);
        }else{
            $main_file = $developer->image;
        }

        if ($request->file('cover')) {
            $mainext = $request->file('cover')->getClientOriginalExtension();
            $main_file_cover = 'developers-cover'.time() . rand(1000, 14000000000) . '.' . $mainext;
            $request->cover->move(public_path('images/media/developers'), $main_file_cover);
        }else{
            $main_file_cover = $developer->cover;
        }

        $data['image'] = $main_file;
        $data['cover'] = $main_file_cover;

        $developer->update($data);
        return redirect()->back()
            ->with('success','Developer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Developer::findorfail($id)->delete();
        return redirect()->back()
            ->with('success','Developer deleted successfully');
    }


}
