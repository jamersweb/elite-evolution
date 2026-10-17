<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Models\categories;
use App\Models\seo;
use App\Models\media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;


class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:post-list', ['only' => ['index']]);
        $this->middleware('permission:post-create', ['only' => ['create','store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


//        $category = blog::when(!auth()->user()->hasRole('Admin'),function ($q){
//            $q->where('user_id',auth()->user()->id)
//                ->leftJoin('media', 'blogs.id', '=', 'media.reference_id')
//                ->where('reference_type','=','blog')
//                ->select('blogs.id','blogs.title','blogs.status','media.image')
//                 })->get();
//
//        dd($category);

        $category = blog::
        leftJoin('media', 'blogs.id', '=', 'media.reference_id')
            ->where('reference_type','=','blog')
            ->select('blogs.id','blogs.title','blogs.status','media.image')
            ->get();

        return view('management.blog.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        if(!auth()->user()->hasPermissionTo('post-create')){
            return abort(401);
        }


        $cate = categories::where('reference_type','blog')->get();
        return view('management.blog.create',compact('cate'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->hasPermissionTo('post-create')){
            return abort(401);
        }



        $validatedData = $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        if ($request->file('image')) {
            $mainext = $request->file('image')->extension();
            $main_file = 'blog'.time() . rand(1000, 14000000000) . '.' . $mainext;
            $request->image->move(public_path('images/media'), $main_file);
        } else {
            $main_file = null;
        }

        $data = [
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'category_id' => $request->category_id,
            'long_description'=> $request->long_description,
            'short_description'=> $request->short_description,
            'status' => $request->status,
        ];
        $categories = blog::create($data);

        $multi_image=
            [
                'reference_id' => $categories->id,
                'reference_type'=>'blog',
                'image' => $main_file,
            ];

        $multi = media::create($multi_image);





        $seo = [
            'reference_id' => $categories->id,
            'meta_title' => $request->meta_title,
            'reference_type' => 'blog',
            'meta_description'=> $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ];

        $search = seo::create($seo);
        return redirect()->route('post.show',$categories->id)->with('success','Blog Created successfully');;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!auth()->user()->hasPermissionTo('post-edit')){
            return abort(401);
        }

        $media = media::where('reference_id',$id)->where('reference_type','blog')->get()->first();
        $category = blog::where('id',$id)->get()->first();
        $seo = seo::where('reference_id',$id)->where('reference_type','blog')->get()->first();

        $all_category = categories::where('reference_type','blog')->get();

        return view('management/blog/edit',compact('category','seo','all_category','media'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {


        if(!auth()->user()->hasPermissionTo('post-edit')){
            return abort(401);
        }




//        dd($request);
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        $multi = media::where('reference_id', $id)->where('reference_type','blog')->get()->first();
        $blogs = blog::where('id',$id)->get()->first();



        if($request->file('image')){

            $ext = $request->file('image')->extension();
            $main_file = 'blog'.time() . rand(1000, 14000000000) . '.' . $ext;
            $request->image->move(public_path('images/media'), $main_file);
        }
        else
        {
            $main_file = $multi->image;
        }

        $blogs->update([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);


        if($multi != null ){
            $multi->update([
                'image' => $main_file,
            ]);
        }else {
            $multi_image =
                [
                    'reference_id' => $id,
                    'reference_type' => 'blog',
                    'image' => $main_file,
                ];

            media::create($multi_image);
        }




        $seo = seo::where('reference_id',$blogs->id)->where('reference_type','blog')->get()->first();

//        $seo->update([
//            'reference_id' => $blogs->id,
//            'meta_title' => $request->meta_title,
//            'reference_type' => 'blog',
//            'meta_description'=> $request->meta_description,
//            'meta_keywords' => $request->meta_keywords,
//        ]);


        if($seo != null ){
            $seo->update([
//        'reference_id' => $categories->id,
                'meta_title' => $request->meta_title,
//        'reference_type' => 'category',
                'meta_description'=> $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]);
        }else{
            seo::create([
                'reference_id' => $id,
                'meta_title' => $request->meta_title,
                'reference_type' => 'blog',
                'meta_description'=> $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]);
        }




        return redirect()->back()->with('success','Blog Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->user()->hasPermissionTo('post-delete')){
            return abort(401);
        }
        $categories = blog::where('id',$id)->delete();
        $seos = seo::where(['reference_id' => $id,'reference_type' => 'blog'])->delete();

        return  redirect()->back()->with('success', 'blog Deleted Succesfully');
    }




}






