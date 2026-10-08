@php
    $bl = $_GET['type'];
@endphp
@extends('management.layouts.master')
@section('title')
    {{base64_decode($bl)}}
@endsection
@section('content')
    <style>

        #upload {
            opacity: 0;
        }

        #upload-label {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
        }

        .image-area {
            border: 2px dashed rgba(255, 255, 255, 0.7);
            padding: 1rem;
            position: relative;
        }

        .image-area::before {
            content: 'Uploaded image result';
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.8rem;
            z-index: 1;
        }

        .image-area img {
            z-index: 2;
            position: relative;
        }

        /*
        *
        * ==========================================
        * FOR DEMO PURPOSES
        * ==========================================
        *
        */
        body {
            min-height: 100vh;
            /*background-color: #757f9a;*/
            /*background-image: linear-gradient(147deg, #757f9a 0%, #d7dde8 100%);*/
        }

        /*
</style>

    <div class="container-fluid px-4">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title"> {{base64_decode($bl)}}</h4>
                            </li>

                        </ul>
                    </div>
                </div>
                {{--                @php--}}
                {{--                    $bl = $_GET['type'];--}}
                {{--                @endphp--}}


                <form action="{{route('coupon.store')}}"  method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card py-4">

                                <div class="header">
                                    <div class="row">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Title </strong></label>
                                            <div class="form-line">
                                                <input value="{{old('title') }}" type="text" id="erp_question_text"
                                                       class="form-control" name="title"
                                                       placeholder="Title" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Affiliate Url </strong></label>
                                            <div class="form-line">
                                                <input value="{{old('affiliate_url')}}" type="text" id="erp_question_text"
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
                                                      rows="10"
                                            > {{old('short_description')}} </textarea>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class=" col-12">
                                            <label for="email_address1">   <strong>   long Description  </strong></label>
                                            <textarea value="{{old('long_description')}}" type="text" name="long_description"
                                                      id="erp_order_message"  class="ckeditor form-control choices" cols="30"
                                                      rows="10"
                                            > {{old('long_description')}}</textarea>
                                        </div>
                                    </div>
                                    <label class="mt-3" for="email_address1">   <strong>  Start & expiry date  </strong></label>

                                    <div class="row my-2">

                                        <div class=" col-6">
                                            <input value="{{old('start_date')}}" id="" name="start_date" class="flatPicker -input active" placeholder="Please choose start date......" type="datetime-local" autocomplete="off">

                                        </div>
                                        <div class="col-6">
                                            <input value="{{old('expiry_date')}}" id="" name="expiry_date" class="flatPicker -input active" placeholder="Please choose end date......" type="datetime-local" autocomplete="off" required>

                                        </div>
                                    </div>
                                    <label class="mt-3" for="email_address1">   <strong>  Pricing  </strong></label>

                                    <div class="row my-2">

                                        <div class=" col-6">
                                            <input value="{{old('regular_price')}}"  name="regular_price" class="-input active" placeholder="Discounted price ......" type="text" autocomplete="off" min="1">

                                        </div>
                                        <div class="col-6">
                                            <input value="{{old('compare_price')}}" name="compare_price" class=" -input active" placeholder="Actual price......" type="text" autocomplete="off" min="1">

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card py-4">
                                <div class="header">
                                    <div class="row">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Meta Title </strong></label>
                                            <div class="form-line">
                                                <input value="{{old('meta_title')}}" type="text" id="erp_question_text"
                                                       class="form-control" name="meta_title"
                                                       placeholder="Meta Title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class=" col-12">
                                            <label for="email_address1">   <strong>  Meta Description </strong></label>
                                            <textarea value="{{old('meta_description') }}" type="text" name="meta_description"
                                                      id="erp_order_message"  class="ckeditor form-control choices" cols="30"
                                                      rows="10"
                                            ></textarea>
                                        </div>
                                    </div>

                                    <div class="row my-4">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Meta Keywords </strong></label>

                                            <div class="form-line">
                                                <input value="{{old('meta_keywords') }}" type="text" id="erp_question_text"
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
                                            <button class="btn btn-primary  my-2 float-right"> Submit   </button>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class=" col-12">
                                            <label for="email_address1">country </label>
                                            <select class="form-control select2" name="country_id" id="Quiz-type" data-placeholder="Select" required>
                                                <option value=""> select </option>
                                                @foreach($country as $row)
                                                    <option {{ old('country_id') == $row->id ? 'Selected' : '' }}  value={{$row->id}}>{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class=" col-12">
                                            <label for="email_address1">Status </label>
                                            <select class="form-control select2" name="status" id="Quiz-type" data-placeholder="Select">
                                                <option {{ old('status') == 1 ? 'Selected' : '' }}  value= 1>Publish</option>
                                                <option {{ old('status') == 0 ? 'Selected' : '' }}  value= 0>draft</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class=" col-12">
                                            <label for="email_address1">Parent Category</label>
                                            <select class="form-control select2" name="category_id" id="Quiz-type" data-placeholder="Select" required>
                                                <option value=""> select </option>
                                                @foreach($cate as $row)
                                                    <option {{ old('category_id') == $row->id ? 'Selected' : '' }}  value={{$row->id}}>{{$row->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class=" col-12">
                                            <label for="email_address1">Store</label>
                                            <select class="form-control select2" name="store_id"  data-placeholder="Select" required>
                                                <option value=""> select </option>
                                                @foreach($store as $str)
                                                    <option {{ old('store_id') == $str->id ? 'Selected' : '' }} value={{$str->id}}>{{$str->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                        <div class="multiimage">

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
{{--                                                                <em>(This is just a demo dropzone. Selected files are--}}
{{--                                                                    <strong>not</strong> actually uploaded.)--}}
{{--                                                                </em>--}}
                                                            </div>
                                                        </div>
                                                        <input type="file" name="image[]"
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

                                    <div class="row my-3">
                                        <div class="col-lg-12 mx-auto">
                                            <label class="d-block">
                                                <input {{ old('featured') == 'featured' ? 'checked' : '' }} value="featured" type="checkbox" class="filled-in" name="featured">
                                                <span>
                                                    featured
                                                </span>
                                            </label>
                                            <label class="d-block">
                                                <input {{ old('trending') == 'trending' ? 'checked' : '' }} value="trending" type="checkbox" class="filled-in" name="trending">
                                                <span>
                                                      trending
                                                </span>
                                            </label>

                                            <label class="d-block">
                                                <input {{ old('popular') == 'hot' ? 'checked' : '' }} value="hot" type="checkbox" class="filled-in" name="popular">
                                                <span>
                                                      hot deals
                                                </span>
                                            </label>
                                            <label class="d-block">
                                                <input {{ old('fullfilled') == 1 ? 'checked' : '' }} value="1" type="checkbox" class="filled-in" name="fullfilled">
                                                <span>
                                                      fulfilled
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row my-1">
                                        <div class="col-12 test">
                                                @if(base64_decode($bl) != 'deals')
                                                    <input type="hidden"  value="coupon"  name="coupon_type">
                                                    <input {{ old('coupon_code') =='coupon_code' ? 'Selected' : '' }}   name="coupon_code" class="flatPicker flatpickr-input active" placeholder="coupon code" type="text" autocomplete="off" min="1">
                                                @else
                                                    <input type="hidden"  value="deals"  name="coupon_type">
                                            @endif
{{--                                            <input   name="discount" class="flatPicker flatpickr-input active" placeholder="Discount %" type="text" autocomplete="off" min="1"></div>--}}
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

                                        </div>
                                    </div>
                                    <input type="file" name="image[]"
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

            $(document).ready(function (){

                if( $('.test select option:selected').val() == "coupon"){
                    $(this).parents('.test').find('.ic').show();
                }
                $('.ic').hide();

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


@endsection

