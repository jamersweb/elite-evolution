@extends('management.layouts.master')
@section('title')
    My Profile -
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <div class="container-fluid px-4">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <ul class="breadcrumb breadcrumb-style ">
                            <li class="breadcrumb-item">
                                <h4 class="page-title"> My Profile</h4>
                            </li>

                        </ul>
                    </div>
                </div>

                <form action="{{url('admin/myprofile')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @php
                            @endphp

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card py-4">

                                <div class="header">
                                    <div class="row">
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Name </strong></label>
                                            <div class="form-line">
                                                <input type="text" id="erp_question_text"
                                                       class="form-control" value="{{Auth()->user()->name}}" name="name"
                                                       placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Occupation </strong></label>
                                            <div class="form-line">
                                                <input type="text" id="occupation"
                                                       class="form-control" value="{{Auth()->user()->occupation}}" name="occupation"
                                                       placeholder="Like: Property consultant, Real Estate Brokerage" required>
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Phone no: </strong></label>
                                            <div class="form-line">
                                                <input type="text" id="erp_question_text"
                                                       class="form-control" name="phone"
                                                       placeholder="Phone no:" value="{{Auth()->user()->phone}}"
                                                       required>
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Whatsapp no: </strong></label>
                                            <div class="form-line">
                                                <input type="text" id="erp_question_text"
                                                       class="form-control" name="whatsapp_no"
                                                       placeholder="Whatsapp no:" value="{{Auth()->user()->whatsapp_no}}"
                                                       required>
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> BRN# </strong></label>
                                            <div class="form-line">
                                                <input type="number" id="erp_question_text"
                                                       class="form-control" name="brn"
                                                       placeholder="BRN#:" value="{{Auth()->user()->brn}}" required>
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Experience Since </strong></label>
                                            <div class="form-line">
                                                <input class="form-control" value="{{Auth()->user()->experience}}"
                                                       type="number" name="experience" id="year-input" min="1900"
                                                       max="2099" step="1" placeholder="YYYY" required>
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Nationality </strong></label>
                                            <div class="form-line">
                                                <input class="form-control" value="{{Auth()->user()->nationality}}"
                                                       type="text" name="nationality" placeholder="Enter Nationality"
                                                       required>
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> Linkedin Url</strong></label>
                                            <div class="form-line">
                                                <input class="form-control" value="{{Auth()->user()->linkedin_url}}"
                                                       type="text" name="linkedin_url" placeholder="Enter Linkedin Url"
                                                       >
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <label for="email_address1"><strong>Areas Name</strong></label>
                                            <div class="form-line">
                                                <input class="form-control"
                                                       value="{{Auth()->user()->area_tags!= null ? implode(', ', json_decode(Auth()->user()->area_tags)) : ''}}"
                                                       type="text" name="area_tags" placeholder="Enter Areas Name"
                                                       id="hotel-tags-input"
                                                       required>
                                            </div>
                                        </div>

                                        <div class="row my-3">
                                            <div class=" col-12">
                                                <label for="email_address1"><strong>Multi Select Language</strong></label>
                                                <select id="choices-multiple-remove-button" multiple
                                                        class="form-control select2" name="language_multi_select[]" id="Quiz-type"
                                                        data-placeholder="Select">
                                                    <option disabled> select</option>
                                                    @if(Auth()->user()->language_multi_select)

                                                        @foreach($languages as $language)
                                                        <option {{in_array($language['English'] ,json_decode(Auth()->user()->language_multi_select)) ? 'selected' : ''}} value="{{$language['English']}}">{{$language['English']}}</option>
                                                        @endforeach
{{--                                                        <option {{in_array('Arabic' ,json_decode(Auth()->user()->language_multi_select)) ? 'selected' : ''}} value="Arabic">Arabic</option>--}}
{{--                                                        <option {{in_array('Russian' ,json_decode(Auth()->user()->language_multi_select)) ? 'selected' : ''}} value="Russian">Russian</option>--}}
{{--                                                        <option {{in_array('German' ,json_decode(Auth()->user()->language_multi_select)) ? 'selected' : ''}} value="German">German</option>--}}
                                                    @else
                                                        @foreach($languages as $language)
                                                            <option value="{{$language['English']}}">{{$language['English']}}</option>
                                                        @endforeach

                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class=" col-12">
                                            <label for="email_address1"> <strong> About </strong></label>
                                            <div class="form-line">
                                                <textarea class="form-control"
                                                          name="about">{{Auth()->user()->about}}</textarea>
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
                                            <button class="btn btn-primary  my-2 float-right"> Submit</button>
                                        </div>
                                    </div>


                                    <div class="row my-3">

                                        <div class="col-lg-12 mx-auto">

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
                                                             style="background-image: url({{asset('images/media/profile').'/'.Auth()->user()->image}});">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

