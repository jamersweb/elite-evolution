<?php

namespace App\Http\Controllers\Management;
use App\Http\Controllers\Controller;

use App\Models\Leads;
use Illuminate\Http\Request;
//use Spatie\Permission\Models\Permission;
//use Spatie\Permission\Models\Role;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:leads-list', ['only' => ['index']]);
        $this->middleware('permission:leads-create', ['only' => ['create','store']]);
        $this->middleware('permission:leads-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:leads-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $roles=[];
        $leads = Leads::select();
//        $leads = User::get();

        if(auth()->user()->hasRole(['Admin','admin'])){
            $leads->where('created_by','!=',0);
        }else{
            $leads->where('created_by',auth()->user()->id);
        }


        if($request->has('status') && $request->status) {
            $leads=$leads->where('status',$request->status);
        }
        if($request->has('id') && $request->id) {
            $leads=$leads->where('id',$request->id);
        }
        if($request->has('property_type') && $request->property_type) {
            $leads=$leads->where('property_type',$request->property_type);
        }
        if($request->has('mobile') && $request->mobile) {
            $leads=$leads->where('mobile',$request->mobile);
        }
        if($request->has('email') && $request->email) {
            $leads=$leads->where('email',$request->email);
        }
        $leads = $leads->get();
        return view('management.lead.index',compact('leads'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $permission = [];
        return view('management.lead.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        $data['quality'] = $request->rating;
        $property = Leads::create($data);
        return redirect()->route('lead.edit',$property->id)->with('success','Lead Created successfully');;
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
//        $permission = Permission::find($id);
//        $permission = Permission::get();
//        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
//            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
//            ->all();
        $leads = Leads::where('id',$id)->first();
        return view('management.lead.edit', compact('leads'));
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
        $data = $request->all();
        if ($request->has('rating')) {
            $data['quality'] = $request->rating;
        }
        $lead = Leads::findOrFail($id);
        $lead->update($data);
        return redirect()->back()
            ->with('success', 'Lead updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lead = Leads::findOrFail($id);
        $lead->delete();
        return redirect()->route('lead.index')
            ->with('success', 'Lead deleted successfully');
    }
}
