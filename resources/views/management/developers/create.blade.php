@extends('management.layouts.master')
@section('title')
    Developers Create - {{config('app.dashboard')}}

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
                                <h4 class="page-title"> Developer</h4>
                            </li>

                        </ul>
                    </div>
                </div>
                {{--                @php--}}
                {{--                    $bl = $_GET['type'];--}}
                {{--                @endphp--}}
                <form action="{{route('developer.store')}}"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <div class="row">
                                        <div class="col-lg-4">

                                            <div class="container">
                                                <h5>Profile Image
                                                </h5>
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        <input type='file' name="image" id="imageUpload"
                                                               accept=".png, .jpg, .jpeg"/>
                                                        <label for="imageUpload"></label>
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview"
                                                             style="background-image: url();">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="main_container">
                                                <div class="main imagebox position-relative rounded-3 overflow-hidden">
                                                    <div class="select_img d-flex justify-content-center align-items-center">
                                                        <div class="dz-message p-3 text-center">
                                                            <div class="drag-icon-cph">
                                                                <i class="material-icons" style="font-size: 35px">touch_app</i>
                                                            </div>
                                                            <h3>Upload Cover.</h3>
                                                        </div>
                                                    </div>
                                                    <input type="file" name="cover" accept=".jpg,.gif,.png,.webp"
                                                           class="main_file w-100 h-100 form-control position-absolute  opacity-0" />
                                                    <div class="img-thumb">
                                                    </div>
                                                </div>
{{--                                                <a class="btn mt-3  fw-normal remove_clone border-0 shadow-none">Remove</a>--}}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card py-4">

                                <div class="header">
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary  my-2 float-right"> Submit   </button>
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
                                    <div class="row mt-3">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Name </strong></label>
                                            <div class="form-line">
                                                <input value="{{old('name') }}" type="text" id="name"
                                                       class="form-control" name="name"
                                                       placeholder="Name" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Meta Title </strong></label>
                                            <div class="form-line">
                                                <input value="{{old('meta_title') }}" type="text" id="meta_title"
                                                       class="form-control" name="meta_title"
                                                       placeholder="Meta Title">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Meta Description </strong></label>
                                            <div class="form-line">
                                                <input value="{{old('meta_description') }}" type="text" id="meta_description"
                                                       class="form-control" name="meta_description"
                                                       placeholder="Meta Description">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Meta keyword </strong></label>
                                            <div class="form-line">
                                                <input value="{{old('meta_tag') }}" type="text" id="meta_tag"
                                                       class="form-control" name="meta_tag"
                                                       placeholder="Meta Keyword">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row my-2">
                                        <div class=" col-12">
                                            <label for="email_address1">   <strong> Description  </strong></label>
                                            <textarea value="{{old('description') }}" type="text" name="description"
                                                      id="erp_order_message"  class="ckeditor form-control choices" cols="30"
                                                      rows="10"
                                            >{{old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>




                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

                <style>
                    .avatar-upload {
                        position: relative;
                        max-width: 205px;
                        margin: 50px auto;
                    }

                    .avatar-upload .avatar-edit {
                        position: absolute;
                        right: 12px;
                        z-index: 1;
                        top: 10px;
                    }

                    .avatar-upload .avatar-edit input {
                        display: none;
                    }

                    .avatar-upload .avatar-edit input + label {
                        display: inline-block;
                        width: 34px;
                        height: 34px;
                        margin-bottom: 0;
                        border-radius: 100%;
                        background: #FFFFFF;
                        border: 1px solid transparent;
                        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                        cursor: pointer;
                        font-weight: normal;
                        transition: all 0.2s ease-in-out;
                    }

                    .avatar-upload .avatar-edit input + label:hover {
                        background: #f1f1f1;
                        border-color: #d6d6d6;
                    }

                    .avatar-upload .avatar-edit input + label:after {
                        content: "\f040";
                        font-family: 'FontAwesome';
                        color: #757575;
                        position: absolute;
                        top: 10px;
                        left: 0;
                        right: 0;
                        text-align: center;
                        margin: auto;
                    }

                    .avatar-upload .avatar-preview {
                        width: 192px;
                        height: 192px;
                        position: relative;
                        border-radius: 100%;
                        border: 6px solid #F8F8F8;
                        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
                    }

                    .avatar-upload .avatar-preview > div {
                        width: 100%;
                        height: 100%;
                        border-radius: 100%;
                        background-size: cover;
                        background-repeat: no-repeat;
                        background-position: center;
                    }

                </style>
                <script>
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                                $('#imagePreview').hide();
                                $('#imagePreview').fadeIn(650);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    // Tags Input Values
                    $(document).ready(function () {
                        var tagInputEle = $('#hotel-tags-input');
                        var tags = tagInputEle.tagsinput();

                    });

                    $("#imageUpload").change(function () {
                        readURL(this);
                    });

                    $(document).ready(function () {
                        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                            removeItemButton: true,
                        });
                    });
                </script>



@endsection

