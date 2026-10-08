@php
    $bl = $_GET['type'];
@endphp
@extends('management.layouts.master')
@section('title')
    {{base64_decode($bl)}}

@endsection
@section('content')

    <div class="container-fluid px-4">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title">  {{base64_decode($bl)}}
                                </h4>
                            </li>

                        </ul>
                    </div>
                </div>
                <form action="{{route('coupon.update',$category->id)}}"  method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card py-4">

                                <div class="header">
                                    <div class="row">
                                        <div class=" col-12">
                                            <label for="email_address1">   <strong>    Title </strong></label>
                                            <div class="form-line">
                                                <input value="{{$category->title}}" type="text" id="erp_question_text"
                                                       class="form-control" name="title"
                                                       placeholder="Title">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Affiliate Url </strong></label>
                                            <div class="form-line">
                                                <input  value="{{$category->affiliate_url}}" type="text" id="erp_question_text"
                                                       class="form-control" name="affiliate_url"
                                                       placeholder="url" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class=" col-12">
                                            <label for="email_address1">   <strong> short Description </strong></label>
                                            <textarea type="text" name="short_description"
                                                      id="erp_order_message"  class="ckeditor form-control choices" cols="30"
                                                      rows="10">

                                                {{$category->short_description}}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class=" col-12">
                                            <label for="email_address1">   <strong>  Long Description </strong></label>
                                            <textarea type="text" name="long_description"
                                                      id="erp_order_message"  class="ckeditor form-control choices" cols="30"
                                                      rows="10">

                                                {{$category->long_description}}
                                            </textarea>
                                        </div>
                                    </div>
                                    <label class="mt-3" for="email_address1">   <strong>  Start & expiry date  </strong></label>

                                    <div class="row my-2">
                                        <div class=" col-6 ">

                                            <input  value="{{$category->start_date}}" id="" name="start_date"  placeholder="Please choose start date......" type="datetime-local" autocomplete="off">

                                        </div>
                                        <div class="col-6">
                                            <input value="{{$category->expiry_date}}" id="myPicker" name="expiry_date" class="flatPicker flatpickr-input active"  type="datetime-local" placeholder="Please choose end date......"  autocomplete="off">

                                        </div>
                                    </div>
                                    <label class="mt-3" for="email_address1">   <strong>  Pricing  </strong></label>

                                    <div class="row my-2">

                                        <div class=" col-6">
                                            <input value="{{$category->regular_price}}" name="regular_price" class="flatPicker flatpickr-input active" placeholder="Discounted price ......" type="text" autocomplete="off" min="1">
                                        </div>
                                        <div class="col-6">
                                            <input value="{{$category->compare_price}}"  name="compare_price" class="flatPicker flatpickr-input active" placeholder="Regular price......" type="text" autocomplete="off" min="1">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card py-4">

                                <div class="header">
                                    <div class="row">
                                        <div class=" col-12">

                                            <label for="email_address1">   <strong>    Meta Title </strong></label>
                                            <div class="form-line">
                                                <input value="{{$seo != null ? $seo->meta_title : ''}}"  type="text" id="erp_question_text"
                                                       class="form-control" name="meta_title"
                                                       placeholder="Meta Title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class=" col-12">
                                            <label for="email_address1">   <strong>  Meta Description </strong></label>
                                            <textarea value="{{old('erp_order_message') }}" type="text" name="meta_description"
                                                      id="erp_order_message"  class="ckeditor form-control choices" cols="30"
                                                      rows="10">
                                                {{$seo != null ? $seo->meta_description : '' }}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="row my-4">
                                        <div class=" col-12">
                                            <label for="email_address1">   <strong>    Meta Keywords  </strong></label>
                                            <div class="form-line">
                                                <input value=" {{$seo != null ? $seo->meta_keywords : '' }}" type="text" id="erp_question_text"
                                                       class="form-control" name="meta_keywords"
                                                       placeholder="Meta Keywords">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">





                                <div class="header">
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary float-right"> Submit   </button>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class=" col-12">
                                            <label for="email_address1">country </label>
                                            <select class="form-control select2" name="country_id" id="Quiz-type" data-placeholder="Select">
                                                <option value=""> select </option>
                                                @foreach($country as $row)
                                                    <option {{$row->id == $category->country_id ? 'selected' : ''}} value={{$row->id}}>{{$row->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class=" col-12">
                                            <label for="email_address1">Status </label>
                                            <select class="form-control select2" name="status" id="Quiz-type" data-placeholder="Select">
                                                <option value="">Select</option>
                                                <option {{$category->status == '1' ? 'selected' : ''}}   value= 1>Publish</option>
                                                <option {{$category->status == '0' ? 'selected' : ''}}  value= 0>draft</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class=" col-12">
                                            <label for="email_address1">Parent Category</label>
                                            <select class="form-control select2" name="category_id" id="Quiz-type" data-placeholder="Select">
                                                <option value=""> select </option>
                                                @foreach($all_category as $row)

                                                    <option {{$category->category_id == $row->id ? 'selected' : ''}}   value={{$row->id}}>{{$row->title}} </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class=" col-12">
                                            <label for="email_address1">Store</label>
                                            <select class="form-control select2" name="store_id"  data-placeholder="Select">
                                                <option value=""> select </option>
                                                @foreach($store as $str)
                                                    <option  {{$str->id == $category->store_id ? 'selected' : ''}}  value={{$str->id}}>{{$str->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="multiimage">
                                        @if($media == null)
{{--                                         @if($media != "")--}}
                                        <div class="row">
                                            <div class="col">
                                                <div class="main_container m-3">
                                                    <div class="main imagebox position-relative rounded-3 overflow-hidden">
                                                        <div class="select_img d-flex justify-content-center align-items-center">
                                                            <div class="dz-message p-3 text-center">
                                                                <div class="drag-icon-cph">
                                                                    <i class="material-icons" style="font-size: 35px">touch_app</i>
                                                                </div>
                                                                <h3>Click to upload.</h3>
{{--                                                                <em>(Selected files are--}}
{{--                                                                    <strong>not</strong> actually uploaded)--}}
{{--                                                                </em>--}}
                                                            </div>
                                                        </div>
                                                        <input type="file" name="image[]" accept=".jpg,.gif,.png"
                                                               class="main_file w-100 h-100 form-control position-absolute  opacity-0" />
                                                        <div class="img-thumb">
                                                        </div>
                                                    </div>
                                                    <a class="btn mt-3  fw-normal add_clone border-0 shadow-none">Add More</a>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
@foreach($media as $image)
                                    <div class="row oldimage">
                                        <div class="col">
                                            <div class="main_container m-3">
                                                    <div class="main imagebox position-relative rounded-3 overflow-hidden">
                                                        <div class="select_img d-flex justify-content-center align-items-center">
                                                            <div class="dz-message p-3 text-center">
                                                                <div class="drag-icon-cph">
                                                                    <i class="material-icons" style="font-size: 35px">touch_app</i>
                                                                </div>
                                                                <h3>Click to upload.</h3>
                                                                <em>(This is just a demo dropzone. Selected files are
                                                                    <strong>not</strong> actually uploaded.)
                                                                </em>
                                                            </div>
                                                        </div>
                                                        <input type="file" name="editimage[{{$media->id}}]" accept=".jpg,.gif,.png"
                                                               class="main_file w-100 h-100 form-control position-absolute  opacity-0" />
                                                        <div class="img-thumb">
                                                            <img class="main_img d-block w-100 h-100 position-absolute" src="{{asset('images/media/'.$media->image)}}">
                                                        </div>
                                                    </div>
                                                <a class="btn mt-3 add_clone fw-normal border-0 shadow-none">Add More</a>
                                                <a class="btn mt-3 remove_lol fw-normal border-0 shadow-none" data-id="{{$media->id}}">Remove</a>

                                            </div>
                                        </div>

                                    </div>
                                    @endforeach
                                    </div>





                                    <div class="row my-3">

                                        <div class="col-lg-12 mx-auto">
                                            <label class="d-block">
                                                <input  {{in_array('featured', $coup) ? 'checked' : ''}}  value="featured" type="checkbox" class="filled-in" name="featured">
                                                <span>

                                                    featured
                                                </span>
                                            </label>
                                            <label  class="d-block">
                                                <input {{in_array('trending', $coup) ? 'checked' : ''}}  value="trending" type="checkbox" class="filled-in" name="trending">
                                                <span>
                                                      trending
                                                </span>
                                            </label>

                                            <label>
                                                <input {{in_array('hot', $coup) ? 'checked' : ''}} value="hot" type="checkbox" class="filled-in" name="popular">
                                                <span  class="d-block">
                                                      hot deals
                                                </span>
                                            </label>
                                            <label class="d-block">
                                                <input {{$category->fullfilled == 1 ? 'checked' : ''}} value="1" type="checkbox" class="filled-in" name="fullfilled">
                                                <span>
                                                      fullfield
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row my-1">
{{--                                        <div class="col-12 test">--}}
{{--                                            --}}
{{--                                            <select class="form-control select2" name="coupon_type" id="Quiz-type" data-placeholder="Select">--}}
{{--                                                <option {{$category->coupon_type == 'deals' ? 'selected' : ''}}   value='deals'> Deals</option>--}}
{{--                                                <option {{$category->coupon_type == 'coupon' ? 'selected' : ''}}  value='coupon'>coupon</option>--}}
{{--                                            </select>--}}
{{--                                            <div class="mt-4 ic " id="" style="{{$category->coupon_type == 'coupon' ? 'display:block;' : ''}}">--}}

{{--                                                <input  value="{{$category->coupon_code}}"  name="coupon_code" class="flatPicker flatpickr-input active" placeholder="coupon code" type="text" autocomplete="off" min="1">--}}

{{--                                            </div>--}}
                                        </div>
                                    <div class="col-12 test">

                                        @if(base64_decode($bl) != 'deals')
                                            <input type="hidden"  value="coupon"  name="coupon_type">
                                                <input  value="{{$category->coupon_code}}"  name="coupon_code" class="flatPicker flatpickr-input active" placeholder="coupon code" type="text" autocomplete="off" min="1">
                                        @else
                                            <input type="hidden"  value="deals"  name="coupon_type">
                                            @endif

{{--                                            <input  value="{{$category->discount}}"  name="discount" class="flatPicker flatpickr-input active" placeholder="Discount %" type="text" autocomplete="off" min="1">--}}

                                    </div>

                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="d-none  cloner" style="display:none;">
                    <div class="row wow-remove">
                        <div class="col">
                            <div class="main_container m-3">
                                <div class="main imagebox position-relative rounded-3 overflow-hidden">
                                    <div class="select_img d-flex justify-content-center align-items-center">
                                        <div class="dz-message p-3 text-center">
                                            <div class="drag-icon-cph">
                                                <i class="material-icons" style="font-size: 35px">touch_app</i>
                                            </div>
                                            <h3>Click to upload.</h3>
                                            <em>( Selected files are
                                                <strong>not</strong> actually uploaded)
                                            </em>
                                        </div>
                                    </div>
                                    <input type="file" name="image[]" accept=".jpg,.gif,.png"
                                           class="main_file w-100 h-100 form-control position-absolute  opacity-0" />
                                    <div class="img-thumb">
                                    </div>
                                </div>
                                <a class="btn mt-3  fw-normal remove_clone border-0 shadow-none">Remove</a>

                                <a class="btn mt-3  fw-normal add_clone border-0 shadow-none">Add More</a>
                            </div>
                        </div>

                    </div>
                </div>





{{--        <div class="d-none  cloner" style="display:none;">--}}
{{--            <div class="row wow-remove">--}}
{{--                <div class="col">--}}
{{--                    <div class="main_container m-3">--}}
{{--                        <div class="main imagebox position-relative rounded-3 overflow-hidden">--}}
{{--                            <div class="select_img d-flex justify-content-center align-items-center">--}}
{{--                                <div class="dz-message p-3 text-center">--}}
{{--                                    <div class="drag-icon-cph">--}}
{{--                                        <i class="material-icons" style="font-size: 35px">touch_app</i>--}}
{{--                                    </div>--}}
{{--                                    <h3>Click to upload.</h3>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <input type="file" name="image"--}}
{{--                                   class="main_file w-100 h-100 form-control position-absolute  opacity-0" />--}}
{{--                            <div class="img-thumb">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <a class="btn mt-3  fw-normal remove_clone border-0 shadow-none">Remove</a>--}}
{{--                        --}}{{--                                <a class="btn mt-3  fw-normal add_clone border-0 shadow-none">Add More</a>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}



        <script>
            $(document).ready(function () {
                var maxField = 10; //Input fields increment limitation
                var addButton = $('.add_clone'); //Add button selector
                var wrapper = $('.team_main'); //Input field wrapper
                var fieldHTML = jQuery('.cloner .row');
                var fieldHTML2 = '<a href="javascript:void(0);" class="remove_button btn btn-dark mx-1">Cancel</a>';
                var x = 1; //Initial field counter is 1

                //Once add button is clicked
                $(document).on('click','.add_clone',function () {
                    var wow = $(this);
                    //Check maximum number of input fields
                    if (x < maxField) {
                        x++;
                        $(wow).parents('.multiimage').append($(fieldHTML).clone());
                    }
                });
                //Once remove button is clicked
                $(document).on('click', '.remove_clone', function (e) {

                    $(this).parents('.wow-remove').remove(); //Remove field html
                    if($(".multiimage .row").length == 0 ){
                        $('.multiimage').append($(fieldHTML).clone());

                    }

                });
            });

        </script>


        <script>
                    $(document).ready(function () {
                        var maxField = 10; //Input fields increment limitation
                        var addButton = $('.add_clone'); //Add button selector
                        var wrapper = $('.team_main'); //Input field wrapper
                        var fieldHTML = jQuery('.cloner .row');
                        var fieldHTML2 = '<a href="javascript:void(0);" class="remove_button btn btn-dark mx-1">Cancel</a>';
                        var x = 1; //Initial field counter is 1

                        //Once add button is clicked
                        // $(document).on('click','.add_clone',function () {
                        //     var wow = $(this);
                        //     //Check maximum number of input fields
                        //     if (x < maxField) {
                        //         x++;
                        //         $(wow).parents('.multiimage').append($(fieldHTML).clone());
                        //     }
                        // });
                        //Once remove button is clicked
                        $(document).on('click', '.remove_clone', function (e) {
                            $(this).parents('.wow-remove',).remove(); //Remove field html
                            x--; //Decrement field counter
                        });
                    });

                </script>
                <style>
                    .img-thumbs {
                        background: #eee;
                        border: 1px solid #ccc;
                        border-radius: 0.25rem;
                        margin: 1.5rem 0;
                        padding: 0.75rem;
                    }
                    .img-thumbs-hidden {
                        display: none;
                    }

                    .wrapper-thumb {
                        position: relative;
                        display:inline-block;
                        margin: 1rem 0;
                        justify-content: space-around;
                    }

                    .img-preview-thumb {
                        background: #fff;
                        border: 1px solid none;
                        border-radius: 0.25rem;
                        box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
                        margin-right: 1rem;
                        max-width: 140px;
                        padding: 0.25rem;
                    }

                    .remove-btn{
                        position:absolute;
                        display:flex;
                        justify-content:center;
                        align-items:center;
                        font-size:.7rem;
                        top:-5px;
                        right:10px;
                        width:20px;
                        height:20px;
                        background:white;
                        border-radius:10px;
                        font-weight:bold;
                        cursor:pointer;
                    }

                    .remove-btn:hover{
                        box-shadow: 0px 0px 3px grey;
                        transition:all .3s ease-in-out;
                    }
                </style>


{{--                <script>--}}
{{--                    var imgUpload = document.getElementById('upload-img')--}}
{{--                        , imgPreview = document.getElementById('img-preview')--}}
{{--                        , imgUploadForm = document.getElementById('form-upload')--}}
{{--                        , totalFiles--}}
{{--                        , previewTitle--}}
{{--                        , previewTitleText--}}
{{--                        , img;--}}

{{--                    imgUpload.addEventListener('change', previewImgs, true);--}}

{{--                    function previewImgs(event) {--}}
{{--                        totalFiles = imgUpload.files.length;--}}

{{--                        if(!!totalFiles) {--}}
{{--                            imgPreview.classList.remove('img-thumbs-hidden');--}}
{{--                        }--}}

{{--                        for(var i = 0; i < totalFiles; i++) {--}}
{{--                            wrapper = document.createElement('div');--}}
{{--                            wrapper.classList.add('wrapper-thumb');--}}
{{--                            removeBtn = document.createElement("span");--}}
{{--                            nodeRemove= document.createTextNode('x');--}}
{{--                            removeBtn.classList.add('remove-btn');--}}
{{--                            removeBtn.appendChild(nodeRemove);--}}
{{--                            img = document.createElement('img');--}}
{{--                            img.src = URL.createObjectURL(event.target.files[i]);--}}
{{--                            img.classList.add('img-preview-thumb');--}}
{{--                            wrapper.appendChild(img);--}}
{{--                            wrapper.appendChild(removeBtn);--}}
{{--                            imgPreview.appendChild(wrapper);--}}

{{--                            $('.remove-btn').click(function(){--}}
{{--                                $(this).parent('.wrapper-thumb').remove();--}}
{{--                            });--}}

{{--                        }--}}


{{--                    }--}}
{{--                </script>--}}





{{--                <script>--}}

{{--                    function readURL(input) {--}}
{{--                        if (input.files && input.files[0]) {--}}
{{--                            var reader = new FileReader();--}}

{{--                            reader.onload = function (e) {--}}
{{--                                $('#imageResult')--}}
{{--                                    .attr('src', e.target.result);--}}
{{--                            };--}}
{{--                            reader.readAsDataURL(input.files[0]);--}}
{{--                        }--}}
{{--                    }--}}

{{--                    $(function () {--}}
{{--                        $('#upload').on('change', function () {--}}
{{--                            readURL(input);--}}
{{--                        });--}}
{{--                    });--}}

{{--                    /*  ==========================================--}}
{{--                        SHOW UPLOADED IMAGE NAME--}}
{{--                    * ========================================== */--}}
{{--                    var input = document.getElementById( 'upload' );--}}
{{--                    var infoArea = document.getElementById( 'upload-label' );--}}

{{--                    input.addEventListener( 'change', showFileName );--}}
{{--                    function showFileName( event ) {--}}
{{--                        var input = event.srcElement;--}}
{{--                        var fileName = input.files[0].name;--}}
{{--                        infoArea.textContent = 'File name: ' + fileName;--}}
{{--                    }--}}

{{--                </script>--}}

                <script>

                    $(document).ready(function (){

                        if( $('.test select option:selected').val() == "coupon"){
                            $(this).parents('.test').find('.ic').show();
                        }else{
                            $('.ic').hide();

                        }

                        $('.test select').on('change', function() {
                            //  alert( this.value ); // or $(this).val()
                            if($(this).val() == "coupon") {
                                $(this).parents('.test').find('.ic').show();
                            } else {
                                $('.ic').hide();
                            }
                        });
                    });


                </script>



                <script>
                    $(document).ready(function () {
                        $(document).on('click', '.remove_lol', function () {
                            var likeaction = $(this).data('id');

                            var actionperformer = $(this);
                                $.ajax({
                                    type: 'POST',
                                    url: "{{url('image-delete')}}",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        id: likeaction,
                                    },
                                    dataType: "json",
                                    beforeSend: function () {
                                        $(".ajaxpreload").show();
                                    },
                                    success: function (data) {
                                     if(data){
                                         $(actionperformer).parents('.oldimage').remove()
                                     }

                                    }
                                });



                        });
                    });

                </script>




@endsection

