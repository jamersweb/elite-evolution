@extends('management.layouts.master')
@section('title')
    {{$property->title}} - {{config('app.dashboard')}}
@endsection
@section('content')

    <style>
        span.select2 {
            width: 100% !important;
        }


        .new-property-tab {
            width: 100%;
            /* height: 76px; */
            padding: 15px;
            background: black;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .new-property-tab ul {
            border: none;
            justify-content: space-between;
            background: transparent;
        }

        .new-property-tab ul li button {
            background: transparent;
            border: none;
            color: #BC9C5B;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .new-property-tab ul li button:hover {
            border: none;
        }

        .new-property-tab ul li .nav-link.active {
            background: transparent;
            color: #BC9C5B;
            border: none;
        }

        .select-option {
            width: 100%;
            border-radius: 10px;
            background-color: transparent;
            padding: 10px;
            border-color: #BC9C5B;
            color: #858383;
        }

        /* .new-property-tab ul li .nav-link.active::after{
         content: "";
         position: absolute;
         width: 100px;
         height: 2px;
         background: #BC9C5B;
        } */
        .location-tab p {
            padding-block: 1rem;
            font-size: 1.1rem;
        }

        .ps-0 {
            padding-left: 0px;
        }

        .dragdrop label {
            border: 2px dashed #BC9C5B;
            width: 50%;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
        }

        .dragdrop {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            padding: 40px;
        }

        .tab-input {
            border: 1px solid #BC9C5B !important;
            border-radius: 10px !important;
            padding-left: 5px !important;
        }

        .tab-next-btn {
            background-color: #BC9C5B;
            font-size: 2rem !important;
            height: 100%;
            color: black !important;
            font-weight: bold;
            padding-inline: 20px;
            margin-right: auto;
            margin-left: auto;
        }

        .types-btn label {
            padding: 30px;
            display: flex;
            justify-content: center;
            height: auto !important;
            align-items: center;
            flex-direction: column;
            height: 150px !important;
        }

        .types-btn label svg g path {
            fill: black !important;
        }

        .types-btn p {
            padding-top: 10px;
            margin-bottom: 0px;
            font-weight: bold;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .types-btn input:checked+label {
            height: auto;
        }

        .types-btn input:checked+label svg path {
            fill: #BC9C5B !important;
        }

        .types-btn input:checked+label .type-checked {
            opacity: 1;
        }

        .types-btn input:checked+label p {
            color: #BC9C5B !important;
        }

        .type-checked {
            opacity: 0;
        }

        .type-checked::after {
            content: url("data:image/svg+xml,%3Csvg width='22' height='22' viewBox='0 0 22 22' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M6 12L9 15L16 8' stroke='%23BC9C5B' stroke-linecap='round' /%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M11 21C16.5228 21 21 16.5228 21 11C21 5.47715 16.5228 1 11 1C5.47715 1 1 5.47715 1 11C1 16.5228 5.47715 21 11 21Z' stroke='%23BC9C5B' /%3E%3C/svg%3E");
            position: absolute;
            top: 5px;
            right: 10px;
        }

        .sit>div {
            margin-bottom: 15px;
        }

        .sit>div select {
            width: 100%;
            border-radius: 10px;
            background-color: transparent;
            padding: 10px;
            border-color: #BC9C5B;
            color: #858383;
        }

        .sit>div input {
            width: 100% !important;
            border-radius: 10px !important;
            border: 1px solid #BC9C5B !important;
            color: #858383;
            text-indent: 10px;
            margin-bottom: 0 !important;
        }

        .sit>div textarea {
            width: 100% !important;
            border-radius: 10px !important;
            border: 1px solid #BC9C5B !important;
            color: #858383;
            text-indent: 10px;
            height: auto !important;
        }

        #imageGallery img {
            width: 25%;
        }

        .smallline {
            width: 30px;
            height: 2px;
            background-color: #BC9C5B;
        }

        .publishcard {
            border: 1px solid #BC9C5B;
        }

        .publishcard img {
            height: 100px;
            width: 30;
            width: 70%;
            object-fit: contain;
            margin-inline: auto;
        }

        .publishcard div {
            display: flex;
            justify-content: space-between;
            margin-block: auto;
            font-size: large;
            font-weight: bold;
        }

        .customhr {
            background-color: #BC9C5B;
            height: 1px;
        }

        .inplace input::-webkit-input-placeholder {
            text-align: justify;
        }

        .sit>div span {
            position: absolute;
            right: 0;
            background: none;
            border: none;
            /*height: 100%;*/
        }

        .headspan {
            left: 10px !important;
            top: 5px;
            font-size: smaller;
        }

        .aedinp {
            height: 60px !important;
            background: #BC9C5B !important;
            color: black !important;
            font-size: x-large !important;
            font-weight: bold !important;
        }
        .aedinp::placeholder{
            color: black !important;
            opacity: 1 !important;
        }




















        .multiSelect {
            width: 100%;
            position: relative;
        }

        .multiSelect *, .multiSelect *::before, .multiSelect *::after {
            box-sizing: border-box;
        }

        .multiSelect_dropdown {
            font-size: 14px;
            min-height: 35px;
            line-height: 35px;
            border-radius: 4px;
            box-shadow: none;
            outline: none;
            background-color: #fff;
            color: #444f5b;
            border: 1px solid #d9dbde;
            font-weight: 400;
            padding: 0.5px 13px;
            margin: 0;
            transition: .1s border-color ease-in-out;
            cursor: pointer;
        }

        .multiSelect_dropdown.-hasValue {
            padding: 5px 30px 5px 5px;
            cursor: default;
        }

        .multiSelect_dropdown.-open {
            box-shadow: none;
            outline: none;
            padding: 4.5px 29.5px 4.5px 4.5px;
            border: 1.5px solid #4073FF;
        }

        .multiSelect_arrow::before,
        .multiSelect_arrow::after {
            content: '';
            position: absolute;
            display: block;
            width: 2px;
            height: 8px;
            border-radius: 20px;
            border-bottom: 8px solid #99A3BA;
            top: 40%;
            transition: all .15s ease;
        }

        .multiSelect_arrow::before {
            right: 18px;
            -webkit-transform: rotate(-50deg);
            transform: rotate(-50deg);
        }

        .multiSelect_arrow::after {
            right: 13px;
            -webkit-transform: rotate(50deg);
            transform: rotate(50deg);
        }

        .multiSelect_list {
            margin: 0;
            margin-bottom: 25px;
            padding: 0;
            list-style: none;
            opacity: 0;
            visibility: hidden;
            position: absolute;
            max-height: calc(10 * 31px);
            top: 28px;
            left: 0;
            z-index: 9999;
            right: 0;
            background: #fff;
            border-radius: 4px;
            overflow-x: hidden;
            overflow-y: auto;
            -webkit-transform-origin: 0 0;
            transform-origin: 0 0;
            transition: opacity 0.1s ease, visibility 0.1s ease, -webkit-transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            transition: opacity 0.1s ease, visibility 0.1s ease, transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            transition: opacity 0.1s ease, visibility 0.1s ease, transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32), -webkit-transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            -webkit-transform: scale(0.8) translate(0, 4px);
            transform: scale(0.8) translate(0, 4px);
            border: 1px solid #d9dbde;
            box-shadow: 0px 10px 20px 0px rgba(0, 0, 0, 0.12);
        }

        .multiSelect_option {
            margin: 0;
            padding: 0;
            opacity: 0;
            -webkit-transform: translate(6px, 0);
            transform: translate(6px, 0);
            transition: all .15s ease;
        }

        .multiSelect_option.-selected {
            display: none;
        }

        .multiSelect_option:hover .multiSelect_text {
            color: #fff;
            background: #4d84fe;
        }

        .multiSelect_text {
            cursor: pointer;
            display: block;
            padding: 5px 13px;
            color: #525c67;
            font-size: 14px;
            text-decoration: none;
            outline: none;
            position: relative;
            transition: all .15s ease;
        }

        .multiSelect_list.-open {
            opacity: 1;
            visibility: visible;
            -webkit-transform: scale(1) translate(0, 12px);
            transform: scale(1) translate(0, 12px);
            transition: opacity 0.15s ease, visibility 0.15s ease, -webkit-transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            transition: opacity 0.15s ease, visibility 0.15s ease, transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            transition: opacity 0.15s ease, visibility 0.15s ease, transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32), -webkit-transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
        }

        .multiSelect_list.-open + .multiSelect_arrow::before {
            -webkit-transform: rotate(-130deg);
            transform: rotate(-130deg);
        }

        .multiSelect_list.-open + .multiSelect_arrow::after {
            -webkit-transform: rotate(130deg);
            transform: rotate(130deg);
        }

        .multiSelect_list.-open .multiSelect_option {
            opacity: 1;
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(1) {
            transition-delay: 10ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(2) {
            transition-delay: 20ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(3) {
            transition-delay: 30ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(4) {
            transition-delay: 40ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(5) {
            transition-delay: 50ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(6) {
            transition-delay: 60ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(7) {
            transition-delay: 70ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(8) {
            transition-delay: 80ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(9) {
            transition-delay: 90ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(10) {
            transition-delay: 100ms;
        }

        .multiSelect_choice {
            background: rgba(77, 132, 254, 0.1);
            color: #444f5b;
            padding: 4px 8px;
            line-height: 17px;
            margin: 5px;
            display: inline-block;
            font-size: 13px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
        }

        .multiSelect_deselect {
            width: 12px;
            height: 12px;
            display: inline-block;
            stroke: #b2bac3;
            stroke-width: 4px;
            margin-top: -1px;
            margin-left: 2px;
            vertical-align: middle;
        }

        .multiSelect_choice:hover .multiSelect_deselect {
            stroke: #a1a8b1;
        }

        .multiSelect_noselections {
            text-align: center;
            padding: 7px;
            color: #b2bac3;
            font-weight: 450;
            margin: 0;
        }

        .multiSelect_placeholder {
            position: absolute;
            left: 20px;
            font-size: 14px;
            top: 8px;
            padding: 0 4px;
            background-color: #fff;
            color: #b8bcbf;
            pointer-events: none;
            transition: all .1s ease;
        }

        .multiSelect_dropdown.-open + .multiSelect_placeholder,
        .multiSelect_dropdown.-open.-hasValue + .multiSelect_placeholder {
            top: -11px;
            left: 17px;
            color: #4073FF;
            font-size: 13px;
        }

        .multiSelect_dropdown.-hasValue + .multiSelect_placeholder {
            top: -11px;
            left: 17px;
            color: #6e7277;
            font-size: 13px;
        }
        .upload__inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
        .upload__btn {
            display: flex;
            font-weight: 600;
            color: #BC9C5B;
            text-align: center;
            width: 200px;
            height: 178px;
            padding: 30px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid;
            background-color: transparent;
            border: 2px dashed #BC9C5B !important;
            border-radius: 10px;
            line-height: 26px;
            font-size: 14px;
            /* margin: auto !important; */
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            margin-bottom: 12px;
        }
        .upload__btn:hover {
            background-color: #BC9C5B;
            color: #000;
            transition: all 0.3s ease;
        }
        .upload__btn-box {
            margin-bottom: 10px;
        }
        .upload__img-wrap {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        .upload__img-box {
            width: 200px;
            padding: 0 10px;
            margin-bottom: 12px;
        }
        .upload__img-close {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 10px;
            right: 10px;
            text-align: center;
            line-height: 24px;
            z-index: 1;
            cursor: pointer;
        }
        .upload__img-close:after {
            content: '\2716';
            font-size: 14px;
            color: white;
        }
        .img-bg {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            padding-bottom: 100%;
        }







    </style>
    <div class="row ">
        <div class="col-12 ">
            <div class="card">
                <div class="body ">
                    <div class="pull-left">
                        <h2>Edit- {{$property->title}} </h2>
                    </div>
                    <div class="pull-right">
                        @can('property-delete')
                            <button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float" data-toggle="modal" data-target="#exampleModalCenter{{$property->id}}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            <div class="modal fade" id="exampleModalCenter{{$property->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Delete
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure want to proceed this action?                                           </div>
                                        <div class="modal-footer">

                                            <button type="submit" class="btn btn-danger waves-effect"
                                                    data-dismiss="modal">Close</button>
                                            <form action="{{route('property.destroy',$property->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-info waves-effect">Delete</button>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endcan
                    </div>
                </div>
            </div>
        </div>

    </div>
{{--    <div class="row">--}}
{{--        <div class="col-lg-12 margin-tb">--}}
{{--            <!-- <div class="pull-left">--}}
{{--                <h2>New Property </h2>--}}
{{--            </div> -->--}}
{{--            <div class="pull-right">--}}
{{--                <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
    <div class="row clearfix">
        <!-- Task Info -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="new-property-tab">

                <ul class="nav nav-tabs tabs" id="myTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="propertydetail-btn" data-bs-toggle="tab" data-bs-target="#propertydetail" type="button" role="tab" aria-controls="property" aria-selected="true">Property Deatils</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="media-btn" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab" aria-controls="media" aria-selected="false">Media</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="location-btn" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab" aria-controls="loacation" aria-selected="false">Location</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="publishing-btn" data-bs-toggle="tab" data-bs-target="#publishing" type="button" role="tab" aria-controls="publishing" aria-selected="false">Publishing</button>
                    </li>
                </ul>

            </div>

            <form action="{{route('property.update',$property->id)}}" method="post"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="tab-content mt-2" id="myTabContent">
                    <div class="tab-pane fade py-3 show active" id="propertydetail" role="tabpanel" aria-labelledby="property-tab">
                        <div class="row">
                            <div class=" col-sm-2 col-6">
                                <div class="card types-btn">
                                    <div>
                                        <input type="checkbox" value="1" {{$property->is_verified == 1 ? 'checked' : ''}}   name="is_verified" id="is_verified" >
                                        <label for="is_verified">
                                            <div class="type-checked">
                                            </div>
                                            <!-- <img width="150px" class="elite-logo" src="{{asset('management/images/elite-logo.png')}}" alt=""> -->
                                            <i class="fa-regular fa-circle-check h1"></i>
                                            <p>

                                                Verified
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>
{{--                            <div class=" col-sm-2 col-6">--}}
{{--                                <div class="card types-btn">--}}
{{--                                    <div>--}}
{{--                                        <input type="checkbox" value="1" {{$property->is_new_project == 1 ? 'checked' : ''}}   name="is_new_project" id="is_new_project" >--}}
{{--                                        <label for="is_new_project">--}}
{{--                                            <div class="type-checked">--}}
{{--                                            </div>--}}
{{--                                            <!-- <img width="150px" class="elite-logo" src="{{asset('management/images/elite-logo.png')}}" alt=""> -->--}}
{{--                                            <svg width="54" height="54" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                <g clip-path="url(#clip0_38_60)">--}}
{{--                                                    <path d="M68.8086 61.5489C69.2168 60.9237 69.6562 60.3328 70.0114 59.6951C72.0088 56.1158 70.2981 51.2798 66.484 49.7699C65.92 49.5479 65.7424 49.2822 65.7424 48.682C65.7642 40.8294 65.758 32.9767 65.758 25.1209V24.2456C66.5058 24.2456 67.1945 24.255 67.8831 24.2425C69.597 24.2175 70.5162 22.8202 69.7933 21.254C66.7208 14.6018 63.6235 7.9589 60.5324 1.3129C60.065 0.303184 59.2423 -4.37988e-05 58.1797 -4.37988e-05C44.9116 0.0155865 31.6434 0.00933437 18.3753 0.00933437C17.724 0.00933437 17.0728 0.0405949 16.4247 0.00308226C15.2624 -0.0625649 14.5332 0.471991 14.044 1.50672C11.9251 5.97072 9.78434 10.4254 7.64985 14.8831C6.67141 16.9276 5.68362 18.9689 4.71141 21.0164C3.83269 22.8639 4.7083 24.2363 6.76489 24.2425H8.44444C8.46002 24.5583 8.48184 24.7927 8.48184 25.0303C8.48184 32.9079 8.48184 40.7825 8.48184 48.6601C8.48495 49.0853 8.48184 49.4073 7.96457 49.6073C3.09107 51.5111 1.64522 57.2443 5.00121 61.28C5.04171 61.3301 5.07911 61.3832 5.08534 61.3988C4.09443 61.9709 3.04744 62.4429 2.15313 63.1182C0.891133 64.0685 0.324012 65.4908 -0.00317383 67.007V72.5182C0.644965 73.6248 1.59848 73.9968 2.87294 73.9968C25.751 73.9718 48.6259 73.9781 71.5009 73.9781C73.4048 73.9781 73.9781 73.3966 73.9812 71.4647C73.9812 70.4488 73.9439 69.4328 73.9875 68.4199C74.1308 65.2376 72.47 62.346 68.8055 61.5458L68.8086 61.5489ZM66.9421 56.494C66.8922 58.3072 65.4059 59.6857 63.583 59.617C61.8318 59.5513 60.4732 58.0602 60.5292 56.2596C60.5853 54.5246 62.0499 53.1335 63.7824 53.1679C65.5897 53.2023 66.9951 54.6809 66.9421 56.494ZM9.86225 19.494C12.2242 14.558 14.5955 9.62508 16.9419 4.67966C17.1787 4.18262 17.4374 3.97943 18.017 3.97943C30.8987 3.99818 43.7805 3.99818 56.6622 3.98255C57.192 3.98255 57.4631 4.13573 57.6905 4.63277C59.9777 9.6032 62.2929 14.5611 64.5988 19.5253C64.6892 19.716 64.7733 19.9129 64.9042 20.2068C64.5801 20.2224 64.3308 20.2474 64.0815 20.2474C59.3389 20.2505 54.5963 20.2412 49.8537 20.2599C49.3457 20.2631 49.0186 20.1067 48.6976 19.7129C45.5847 15.8991 42.453 12.104 39.3276 8.30276C39.2497 8.21211 39.1749 8.1152 39.097 8.02454C37.9503 6.66158 36.6696 6.65846 35.5323 8.01204C32.2417 11.929 28.9605 15.8491 25.6513 19.7473C25.4363 20.0005 25.025 20.2255 24.7071 20.2287C19.8679 20.2599 15.0255 20.2505 10.1863 20.2474C10.0025 20.2474 9.81551 20.2193 9.56622 20.1974C9.6784 19.9254 9.76253 19.7035 9.86225 19.494ZM10.4418 53.1648C12.2149 53.1773 13.6451 54.6184 13.6451 56.3909C13.6451 58.1634 12.2211 59.6138 10.4512 59.6201C8.67191 59.6295 7.23541 58.2134 7.21672 56.4346C7.19802 54.6215 8.64387 53.1554 10.4418 53.1648ZM22.6349 69.9486H4.05704C4.05704 69.0389 3.98226 68.148 4.07885 67.2758C4.17234 66.4349 5.08846 65.694 6.00769 65.5534C6.29125 65.5096 6.58416 65.5002 6.87084 65.5002C11.8783 65.4971 16.8858 65.4971 21.8933 65.5002C22.127 65.5002 22.3638 65.519 22.6349 65.5346V69.9486ZM39.3463 70.1955H34.6941C34.6723 70.0549 34.6411 69.9423 34.6411 69.8298C34.638 66.5725 34.6286 63.3151 34.6442 60.0609C34.6504 58.8355 35.2425 57.9602 36.2178 57.6257C37.6948 57.1193 39.2404 58.1133 39.3121 59.7045C39.3837 61.3426 39.3432 62.9869 39.3463 64.6249C39.3494 66.4568 39.3463 68.2887 39.3463 70.1955ZM47.0897 63.9747V69.9517H43.3473V69.1702C43.3473 66.1754 43.3691 63.1776 43.3411 60.1828C43.3162 57.4756 42.2006 55.3905 39.7452 54.1245C36.0402 52.2176 31.1885 54.7466 30.7834 58.9011C30.5684 61.0831 30.665 63.2932 30.6401 65.4877C30.6214 66.9601 30.637 68.4325 30.637 69.9673H26.9289C26.9164 69.686 26.8977 69.4328 26.8946 69.1796C26.8946 67.3665 26.9008 65.5534 26.8915 63.7434C26.8852 62.296 26.0969 61.5051 24.651 61.4989C21.9089 61.4895 19.1637 61.4989 16.4184 61.4989H15.8139C16.3249 60.4329 16.9544 59.4263 17.3003 58.3322C18.3691 54.931 16.4807 51.0672 13.1715 49.773C12.6075 49.5511 12.4299 49.2854 12.4299 48.682C12.4517 40.8294 12.4455 32.9767 12.4455 25.1241V24.2488H13.2743C17.4405 24.2488 21.6066 24.2331 25.7728 24.2582C26.6952 24.2644 27.3776 23.9518 27.9634 23.2453C30.8987 19.7222 33.8527 16.2179 36.8005 12.7074C36.9376 12.5448 37.081 12.3823 37.2866 12.1447C37.4705 12.3573 37.6418 12.5386 37.8039 12.7324C40.6395 16.1804 43.4876 19.616 46.2982 23.0828C46.962 23.9018 47.7098 24.2769 48.7755 24.2644C52.8201 24.2238 56.8648 24.2488 60.9094 24.2488H61.7819V25.0897C61.7819 32.9423 61.7757 40.795 61.7975 48.6476C61.7975 49.2291 61.623 49.4729 61.0808 49.6792C56.5532 51.3861 55.0512 57.1349 58.1237 60.8987C58.2545 61.0581 58.3667 61.23 58.5661 61.4989H57.1733C54.6461 61.4989 52.1159 61.4957 49.5888 61.4989C47.9155 61.502 47.0928 62.3241 47.0897 63.9747ZM69.9865 69.958H51.1094V65.5377C51.3836 65.5252 51.636 65.5002 51.8916 65.5002C57.0891 65.4971 62.2836 65.4971 67.478 65.5002C69.2542 65.5002 69.9615 66.213 69.9865 68.0011C69.9927 68.6263 69.9865 69.2484 69.9865 69.958Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M29.8954 34.9211C29.858 36.1153 29.0323 36.9749 27.9292 36.9906C26.8261 37.0093 25.9505 36.1809 25.91 34.9774C25.8633 33.5832 25.8664 32.1858 25.9069 30.7885C25.9443 29.5881 26.8137 28.744 27.9074 28.7503C29.0323 28.7565 29.8674 29.6412 29.8986 30.876C29.9141 31.5481 29.8986 32.2233 29.8986 32.8986C29.8986 33.5738 29.9141 34.249 29.8923 34.9211H29.8954Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M39.0784 35.1525C39.0223 36.281 38.1093 37.0251 37.0561 36.9907C35.9841 36.9563 35.1646 36.106 35.1241 34.9619C35.1023 34.2616 35.121 33.5645 35.121 32.8643C35.121 32.164 35.1023 31.4669 35.1272 30.7698C35.1677 29.6319 35.9997 28.7816 37.0685 28.7504C38.1093 28.7222 39.0285 29.4913 39.0815 30.6073C39.1532 32.1203 39.1532 33.6427 39.0784 35.1525Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M29.8922 47.2253C29.8454 48.3945 29.0321 49.2073 27.9353 49.2229C26.8353 49.2416 25.9628 48.4632 25.9161 47.291C25.86 45.8436 25.86 44.3931 25.9161 42.9458C25.9628 41.7735 26.8353 41.0014 27.9415 41.0201C29.0384 41.0389 29.8485 41.8516 29.8953 43.0239C29.9202 43.7241 29.8984 44.4244 29.8984 45.1246C29.8984 45.8249 29.9233 46.5251 29.8922 47.2253Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M39.0908 47.3348C39.0347 48.5102 38.1467 49.2604 37.0374 49.2229C35.9467 49.1823 35.1584 48.3539 35.1241 47.1785C35.1023 46.4782 35.121 45.778 35.121 45.0778C35.121 44.3775 35.1023 43.7273 35.1241 43.049C35.1615 41.8798 35.9592 41.0514 37.0498 41.0233C38.1623 40.992 39.041 41.7423 39.0908 42.9208C39.1563 44.39 39.1563 45.8655 39.0908 47.3348Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M20.6688 32.8799C20.6688 33.5801 20.6844 34.2804 20.6657 34.9806C20.6346 36.1216 19.7932 36.975 18.7151 36.9938C17.6525 37.0094 16.7675 36.2373 16.727 35.1119C16.6678 33.6176 16.6678 32.1171 16.727 30.6229C16.7706 29.51 17.6774 28.7222 18.7275 28.7504C19.8026 28.7785 20.6346 29.6382 20.6657 30.7792C20.6844 31.4763 20.6688 32.1796 20.6688 32.8799Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M20.6689 45.1434C20.6689 45.8437 20.6844 46.5439 20.6657 47.2441C20.6315 48.3695 19.84 49.1792 18.7712 49.2229C17.6556 49.2667 16.7676 48.5102 16.7239 47.3442C16.6678 45.8499 16.6678 44.3494 16.7302 42.8551C16.7769 41.7298 17.6525 40.9951 18.7431 41.0202C19.8151 41.0483 20.6252 41.8548 20.6626 42.9708C20.6876 43.6929 20.6689 44.4182 20.6689 45.1434Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M57.5222 34.9649C57.5035 36.1278 56.684 36.9687 55.5965 36.9937C54.481 37.0188 53.6209 36.181 53.5773 34.9837C53.5493 34.2835 53.5711 33.5832 53.5711 32.883H53.5742C53.5742 32.1577 53.5493 31.4325 53.5804 30.7104C53.6303 29.5694 54.5028 28.7347 55.5778 28.7503C56.656 28.766 57.5035 29.6163 57.5222 30.7635C57.5472 32.164 57.544 33.5645 57.5222 34.9649Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M48.3081 32.8861C48.3081 33.6113 48.3392 34.3366 48.2987 35.0587C48.2364 36.2153 47.3764 37.0219 46.2857 36.9906C45.2045 36.9625 44.3725 36.1122 44.3569 34.9618C44.3351 33.5613 44.332 32.1608 44.3569 30.7604C44.3756 29.6225 45.2356 28.7659 46.3107 28.7503C47.3826 28.7316 48.2457 29.56 48.3018 30.7135C48.3392 31.4356 48.3081 32.1608 48.3081 32.8861Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M48.2894 47.3753C48.2489 48.4882 47.3701 49.2478 46.2858 49.2228C45.2138 49.2009 44.3974 48.3975 44.3569 47.2847C44.332 46.5594 44.3538 45.8373 44.3538 45.1121C44.3538 44.3868 44.332 43.6616 44.36 42.9394C44.4005 41.8297 45.2294 41.0326 46.3045 41.0201C47.392 41.0075 48.2551 41.7641 48.2894 42.8863C48.3392 44.3806 48.3392 45.8811 48.2894 47.3753Z" fill="#BC9C5B" />--}}
{{--                                                    <path d="M57.5161 47.3317C57.4693 48.4383 56.628 49.2292 55.5499 49.226C54.4966 49.226 53.6304 48.4664 53.5961 47.3973C53.5493 45.878 53.5493 44.3557 53.5961 42.8364C53.6304 41.7673 54.4966 41.017 55.553 41.0202C56.6374 41.0202 57.4538 41.8079 57.5223 42.9145C57.5254 42.9646 57.5285 43.0115 57.5285 43.0583C57.5317 43.7586 57.5285 44.4588 57.5285 45.1591H57.5223C57.5223 45.8843 57.5472 46.6095 57.5161 47.3317Z" fill="#BC9C5B" />--}}
{{--                                                </g>--}}
{{--                                                <defs>--}}
{{--                                                    <clipPath id="clip0_38_60">--}}
{{--                                                        <rect width="74" height="74" fill="white" />--}}
{{--                                                    </clipPath>--}}
{{--                                                </defs>--}}
{{--                                            </svg>--}}
{{--                                            <p>--}}
{{--                                                New Project--}}
{{--                                            </p>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <div class="row sit">
                            <div class="col-sm-6">
                                <select class="form-select bg-white" name="developer_id" aria-label="Default select example">
                                    <option selected="" value="">Choose Developers</option>
                                    @foreach($developer as $developers)
                                        <option {{$developers->id == $property->developer_id ? 'selected' : '' }} value="{{$developers->id}}">{{$developers->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <select class="form-select bg-white" name="user_id">
                                    <option value="">Assign to Licensed Broker</option>
                                    @foreach($agents as $agentItem)
                                        <option value="{{$agentItem->id}}" {{ $property->user_id == $agentItem->id ? 'selected' : '' }}>
                                            {{$agentItem->name}} (BRN: {{$agentItem->brn ?? 'N/A'}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card p-3 my-3 border shadow-sm">
                            <h4 class="font-weight-bold" style="color: #b38b47;"><i class="fas fa-shield-alt mr-2"></i> DLD Regulatory Compliance (Madmoun / Trakheesi)</h4>
                            <div class="row sit">
                                <div class="col-sm-4">
                                    <label class="font-weight-bold small">Property Reference Number</label>
                                    <input type="text" name="reference_no" placeholder="e.g. EERE-V-101" value="{{ old('reference_no', $property->reference_no) }}">
                                </div>
                                <div class="col-sm-4">
                                    <label class="font-weight-bold small">Trakheesi Permit Number <span class="text-danger">*</span></label>
                                    <input type="text" name="trakheesi_permit_no" placeholder="e.g. 7123984501" value="{{ old('trakheesi_permit_no', $property->trakheesi_permit_no) }}">
                                </div>
                                <div class="col-sm-4">
                                    <label class="font-weight-bold small">Madmoun Verification QR Code Image</label>
                                    <input type="file" name="permit_qr_image" accept="image/*">
                                    @if($property->permit_qr_image)
                                        <small class="text-success d-block mt-1"><i class="fas fa-check mr-1"></i> QR Code uploaded</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h2>Types</h2>
                        <div class="row">
                            <div class=" col-sm-3 col-6">
                                <div class="card types-btn">
                                    <div>
                                        <input type="radio" {{$property->land_type == 'residential' ? 'checked' : ''}} value="residential"  name="land_type" id="residential">
                                        <label for="residential">
                                            <div class="type-checked">
                                            </div>
                                            <!-- <img width="150px" class="elite-logo" src="{{asset('management/images/elite-logo.png')}}" alt=""> -->
                                            <svg width="54" height="54" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_38_60)">
                                                    <path d="M68.8086 61.5489C69.2168 60.9237 69.6562 60.3328 70.0114 59.6951C72.0088 56.1158 70.2981 51.2798 66.484 49.7699C65.92 49.5479 65.7424 49.2822 65.7424 48.682C65.7642 40.8294 65.758 32.9767 65.758 25.1209V24.2456C66.5058 24.2456 67.1945 24.255 67.8831 24.2425C69.597 24.2175 70.5162 22.8202 69.7933 21.254C66.7208 14.6018 63.6235 7.9589 60.5324 1.3129C60.065 0.303184 59.2423 -4.37988e-05 58.1797 -4.37988e-05C44.9116 0.0155865 31.6434 0.00933437 18.3753 0.00933437C17.724 0.00933437 17.0728 0.0405949 16.4247 0.00308226C15.2624 -0.0625649 14.5332 0.471991 14.044 1.50672C11.9251 5.97072 9.78434 10.4254 7.64985 14.8831C6.67141 16.9276 5.68362 18.9689 4.71141 21.0164C3.83269 22.8639 4.7083 24.2363 6.76489 24.2425H8.44444C8.46002 24.5583 8.48184 24.7927 8.48184 25.0303C8.48184 32.9079 8.48184 40.7825 8.48184 48.6601C8.48495 49.0853 8.48184 49.4073 7.96457 49.6073C3.09107 51.5111 1.64522 57.2443 5.00121 61.28C5.04171 61.3301 5.07911 61.3832 5.08534 61.3988C4.09443 61.9709 3.04744 62.4429 2.15313 63.1182C0.891133 64.0685 0.324012 65.4908 -0.00317383 67.007V72.5182C0.644965 73.6248 1.59848 73.9968 2.87294 73.9968C25.751 73.9718 48.6259 73.9781 71.5009 73.9781C73.4048 73.9781 73.9781 73.3966 73.9812 71.4647C73.9812 70.4488 73.9439 69.4328 73.9875 68.4199C74.1308 65.2376 72.47 62.346 68.8055 61.5458L68.8086 61.5489ZM66.9421 56.494C66.8922 58.3072 65.4059 59.6857 63.583 59.617C61.8318 59.5513 60.4732 58.0602 60.5292 56.2596C60.5853 54.5246 62.0499 53.1335 63.7824 53.1679C65.5897 53.2023 66.9951 54.6809 66.9421 56.494ZM9.86225 19.494C12.2242 14.558 14.5955 9.62508 16.9419 4.67966C17.1787 4.18262 17.4374 3.97943 18.017 3.97943C30.8987 3.99818 43.7805 3.99818 56.6622 3.98255C57.192 3.98255 57.4631 4.13573 57.6905 4.63277C59.9777 9.6032 62.2929 14.5611 64.5988 19.5253C64.6892 19.716 64.7733 19.9129 64.9042 20.2068C64.5801 20.2224 64.3308 20.2474 64.0815 20.2474C59.3389 20.2505 54.5963 20.2412 49.8537 20.2599C49.3457 20.2631 49.0186 20.1067 48.6976 19.7129C45.5847 15.8991 42.453 12.104 39.3276 8.30276C39.2497 8.21211 39.1749 8.1152 39.097 8.02454C37.9503 6.66158 36.6696 6.65846 35.5323 8.01204C32.2417 11.929 28.9605 15.8491 25.6513 19.7473C25.4363 20.0005 25.025 20.2255 24.7071 20.2287C19.8679 20.2599 15.0255 20.2505 10.1863 20.2474C10.0025 20.2474 9.81551 20.2193 9.56622 20.1974C9.6784 19.9254 9.76253 19.7035 9.86225 19.494ZM10.4418 53.1648C12.2149 53.1773 13.6451 54.6184 13.6451 56.3909C13.6451 58.1634 12.2211 59.6138 10.4512 59.6201C8.67191 59.6295 7.23541 58.2134 7.21672 56.4346C7.19802 54.6215 8.64387 53.1554 10.4418 53.1648ZM22.6349 69.9486H4.05704C4.05704 69.0389 3.98226 68.148 4.07885 67.2758C4.17234 66.4349 5.08846 65.694 6.00769 65.5534C6.29125 65.5096 6.58416 65.5002 6.87084 65.5002C11.8783 65.4971 16.8858 65.4971 21.8933 65.5002C22.127 65.5002 22.3638 65.519 22.6349 65.5346V69.9486ZM39.3463 70.1955H34.6941C34.6723 70.0549 34.6411 69.9423 34.6411 69.8298C34.638 66.5725 34.6286 63.3151 34.6442 60.0609C34.6504 58.8355 35.2425 57.9602 36.2178 57.6257C37.6948 57.1193 39.2404 58.1133 39.3121 59.7045C39.3837 61.3426 39.3432 62.9869 39.3463 64.6249C39.3494 66.4568 39.3463 68.2887 39.3463 70.1955ZM47.0897 63.9747V69.9517H43.3473V69.1702C43.3473 66.1754 43.3691 63.1776 43.3411 60.1828C43.3162 57.4756 42.2006 55.3905 39.7452 54.1245C36.0402 52.2176 31.1885 54.7466 30.7834 58.9011C30.5684 61.0831 30.665 63.2932 30.6401 65.4877C30.6214 66.9601 30.637 68.4325 30.637 69.9673H26.9289C26.9164 69.686 26.8977 69.4328 26.8946 69.1796C26.8946 67.3665 26.9008 65.5534 26.8915 63.7434C26.8852 62.296 26.0969 61.5051 24.651 61.4989C21.9089 61.4895 19.1637 61.4989 16.4184 61.4989H15.8139C16.3249 60.4329 16.9544 59.4263 17.3003 58.3322C18.3691 54.931 16.4807 51.0672 13.1715 49.773C12.6075 49.5511 12.4299 49.2854 12.4299 48.682C12.4517 40.8294 12.4455 32.9767 12.4455 25.1241V24.2488H13.2743C17.4405 24.2488 21.6066 24.2331 25.7728 24.2582C26.6952 24.2644 27.3776 23.9518 27.9634 23.2453C30.8987 19.7222 33.8527 16.2179 36.8005 12.7074C36.9376 12.5448 37.081 12.3823 37.2866 12.1447C37.4705 12.3573 37.6418 12.5386 37.8039 12.7324C40.6395 16.1804 43.4876 19.616 46.2982 23.0828C46.962 23.9018 47.7098 24.2769 48.7755 24.2644C52.8201 24.2238 56.8648 24.2488 60.9094 24.2488H61.7819V25.0897C61.7819 32.9423 61.7757 40.795 61.7975 48.6476C61.7975 49.2291 61.623 49.4729 61.0808 49.6792C56.5532 51.3861 55.0512 57.1349 58.1237 60.8987C58.2545 61.0581 58.3667 61.23 58.5661 61.4989H57.1733C54.6461 61.4989 52.1159 61.4957 49.5888 61.4989C47.9155 61.502 47.0928 62.3241 47.0897 63.9747ZM69.9865 69.958H51.1094V65.5377C51.3836 65.5252 51.636 65.5002 51.8916 65.5002C57.0891 65.4971 62.2836 65.4971 67.478 65.5002C69.2542 65.5002 69.9615 66.213 69.9865 68.0011C69.9927 68.6263 69.9865 69.2484 69.9865 69.958Z" fill="#BC9C5B" />
                                                    <path d="M29.8954 34.9211C29.858 36.1153 29.0323 36.9749 27.9292 36.9906C26.8261 37.0093 25.9505 36.1809 25.91 34.9774C25.8633 33.5832 25.8664 32.1858 25.9069 30.7885C25.9443 29.5881 26.8137 28.744 27.9074 28.7503C29.0323 28.7565 29.8674 29.6412 29.8986 30.876C29.9141 31.5481 29.8986 32.2233 29.8986 32.8986C29.8986 33.5738 29.9141 34.249 29.8923 34.9211H29.8954Z" fill="#BC9C5B" />
                                                    <path d="M39.0784 35.1525C39.0223 36.281 38.1093 37.0251 37.0561 36.9907C35.9841 36.9563 35.1646 36.106 35.1241 34.9619C35.1023 34.2616 35.121 33.5645 35.121 32.8643C35.121 32.164 35.1023 31.4669 35.1272 30.7698C35.1677 29.6319 35.9997 28.7816 37.0685 28.7504C38.1093 28.7222 39.0285 29.4913 39.0815 30.6073C39.1532 32.1203 39.1532 33.6427 39.0784 35.1525Z" fill="#BC9C5B" />
                                                    <path d="M29.8922 47.2253C29.8454 48.3945 29.0321 49.2073 27.9353 49.2229C26.8353 49.2416 25.9628 48.4632 25.9161 47.291C25.86 45.8436 25.86 44.3931 25.9161 42.9458C25.9628 41.7735 26.8353 41.0014 27.9415 41.0201C29.0384 41.0389 29.8485 41.8516 29.8953 43.0239C29.9202 43.7241 29.8984 44.4244 29.8984 45.1246C29.8984 45.8249 29.9233 46.5251 29.8922 47.2253Z" fill="#BC9C5B" />
                                                    <path d="M39.0908 47.3348C39.0347 48.5102 38.1467 49.2604 37.0374 49.2229C35.9467 49.1823 35.1584 48.3539 35.1241 47.1785C35.1023 46.4782 35.121 45.778 35.121 45.0778C35.121 44.3775 35.1023 43.7273 35.1241 43.049C35.1615 41.8798 35.9592 41.0514 37.0498 41.0233C38.1623 40.992 39.041 41.7423 39.0908 42.9208C39.1563 44.39 39.1563 45.8655 39.0908 47.3348Z" fill="#BC9C5B" />
                                                    <path d="M20.6688 32.8799C20.6688 33.5801 20.6844 34.2804 20.6657 34.9806C20.6346 36.1216 19.7932 36.975 18.7151 36.9938C17.6525 37.0094 16.7675 36.2373 16.727 35.1119C16.6678 33.6176 16.6678 32.1171 16.727 30.6229C16.7706 29.51 17.6774 28.7222 18.7275 28.7504C19.8026 28.7785 20.6346 29.6382 20.6657 30.7792C20.6844 31.4763 20.6688 32.1796 20.6688 32.8799Z" fill="#BC9C5B" />
                                                    <path d="M20.6689 45.1434C20.6689 45.8437 20.6844 46.5439 20.6657 47.2441C20.6315 48.3695 19.84 49.1792 18.7712 49.2229C17.6556 49.2667 16.7676 48.5102 16.7239 47.3442C16.6678 45.8499 16.6678 44.3494 16.7302 42.8551C16.7769 41.7298 17.6525 40.9951 18.7431 41.0202C19.8151 41.0483 20.6252 41.8548 20.6626 42.9708C20.6876 43.6929 20.6689 44.4182 20.6689 45.1434Z" fill="#BC9C5B" />
                                                    <path d="M57.5222 34.9649C57.5035 36.1278 56.684 36.9687 55.5965 36.9937C54.481 37.0188 53.6209 36.181 53.5773 34.9837C53.5493 34.2835 53.5711 33.5832 53.5711 32.883H53.5742C53.5742 32.1577 53.5493 31.4325 53.5804 30.7104C53.6303 29.5694 54.5028 28.7347 55.5778 28.7503C56.656 28.766 57.5035 29.6163 57.5222 30.7635C57.5472 32.164 57.544 33.5645 57.5222 34.9649Z" fill="#BC9C5B" />
                                                    <path d="M48.3081 32.8861C48.3081 33.6113 48.3392 34.3366 48.2987 35.0587C48.2364 36.2153 47.3764 37.0219 46.2857 36.9906C45.2045 36.9625 44.3725 36.1122 44.3569 34.9618C44.3351 33.5613 44.332 32.1608 44.3569 30.7604C44.3756 29.6225 45.2356 28.7659 46.3107 28.7503C47.3826 28.7316 48.2457 29.56 48.3018 30.7135C48.3392 31.4356 48.3081 32.1608 48.3081 32.8861Z" fill="#BC9C5B" />
                                                    <path d="M48.2894 47.3753C48.2489 48.4882 47.3701 49.2478 46.2858 49.2228C45.2138 49.2009 44.3974 48.3975 44.3569 47.2847C44.332 46.5594 44.3538 45.8373 44.3538 45.1121C44.3538 44.3868 44.332 43.6616 44.36 42.9394C44.4005 41.8297 45.2294 41.0326 46.3045 41.0201C47.392 41.0075 48.2551 41.7641 48.2894 42.8863C48.3392 44.3806 48.3392 45.8811 48.2894 47.3753Z" fill="#BC9C5B" />
                                                    <path d="M57.5161 47.3317C57.4693 48.4383 56.628 49.2292 55.5499 49.226C54.4966 49.226 53.6304 48.4664 53.5961 47.3973C53.5493 45.878 53.5493 44.3557 53.5961 42.8364C53.6304 41.7673 54.4966 41.017 55.553 41.0202C56.6374 41.0202 57.4538 41.8079 57.5223 42.9145C57.5254 42.9646 57.5285 43.0115 57.5285 43.0583C57.5317 43.7586 57.5285 44.4588 57.5285 45.1591H57.5223C57.5223 45.8843 57.5472 46.6095 57.5161 47.3317Z" fill="#BC9C5B" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_38_60">
                                                        <rect width="74" height="74" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p>
                                                Residential
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-sm-3 col-6">
                                <div class="card types-btn">
                                    <div>

                                        <input type="radio" {{$property->land_type == 'commercial' ? 'checked' : ''}} value="commercial" name="land_type" id="Commercial ">
                                        <label for="Commercial ">
                                            <div class="type-checked">
                                            </div>
                                            <!-- <img width="150px" class="elite-logo" src="{{asset('management/images/elite-logo.png')}}" alt=""> -->
                                            <svg width="74" height="74" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_38_79)">
                                                    <path d="M72.3835 21.1045H56.0429C56.0429 17.6852 56.0449 14.3986 56.0429 11.1141C56.0409 9.87013 55.9 9.67812 54.7019 9.35947C43.0558 6.27921 31.4075 3.19894 19.7613 0.120709C18.4694 -0.220408 17.9856 0.143178 17.9816 1.46475C17.9754 4.19165 17.9795 6.9165 17.9795 9.6434V10.536H17.0692C11.9013 10.536 6.73338 10.534 1.56546 10.536C0.32859 10.536 0.0244744 10.8363 0.0244744 12.0537C0.0244744 16.9192 0.0244744 21.7868 0.0244744 26.6523C0.0244744 27.8002 0.0203923 28.9461 0.0285564 30.0921C0.0346796 30.7498 0.353082 31.1706 1.03071 31.1992C1.71242 31.2298 2.04511 30.8111 2.12879 30.1758C2.1594 29.9511 2.14308 29.7183 2.14308 29.4895V12.7135H17.8877V18.3061H17.0202C14.3975 18.3061 11.7768 18.3021 9.15405 18.3082C8.09475 18.3082 7.78247 18.6187 7.77635 19.6727C7.76614 21.2782 7.77023 22.8837 7.77431 24.4871C7.77635 25.7801 8.05393 26.0599 9.34591 26.062C11.9176 26.0681 14.4893 26.062 17.059 26.0661C17.3305 26.0661 17.5999 26.0906 17.8795 26.1049V31.6853H16.9978C14.3995 31.6873 11.8033 31.6812 9.20712 31.6894C8.11108 31.6914 7.78247 32.0203 7.77635 33.0967C7.76614 34.7268 7.76819 36.3588 7.77431 37.9888C7.78043 39.1388 8.08251 39.4432 9.21733 39.4432C11.8401 39.4473 14.4608 39.4452 17.0835 39.4452H17.8897V45.0951H17.0223C14.3995 45.0951 11.7768 45.093 9.15405 45.0971C8.12537 45.0992 7.78247 45.4362 7.77635 46.4698C7.76614 48.0998 7.77023 49.7298 7.77431 51.3618C7.77839 52.5364 8.10292 52.8652 9.26427 52.8673C11.8605 52.8713 14.4567 52.8693 17.0549 52.8693H17.8897V58.5069H17.0264C14.4036 58.5069 11.7809 58.5028 9.15813 58.509C8.09271 58.5131 7.78247 58.8154 7.77635 59.8694C7.76614 61.5259 7.76819 63.1804 7.77635 64.837C7.78043 65.94 8.08047 66.2362 9.19283 66.2403C11.8135 66.2444 14.4363 66.2403 17.059 66.2403H17.8877V71.8432H2.14103V70.9077C2.14103 67.0083 2.14308 63.111 2.13695 59.2116C2.13695 58.9093 2.13287 58.5948 2.05327 58.3068C1.90223 57.7655 1.46341 57.4468 0.95723 57.6163C0.595966 57.7369 0.308179 58.1474 0.0530489 58.4783C-0.0469621 58.6091 0.0244744 58.8746 0.0244744 59.0789C0.0244744 63.5379 0.0244744 67.9969 0.0244744 72.4539C0.0244744 73.7367 0.291851 74.0002 1.60016 74.0002H72.4018C73.7449 74.0002 73.9979 73.7449 73.9979 72.3967C73.9979 55.8352 74 39.2736 73.9979 22.7121C73.9979 21.3946 73.7081 21.1045 72.3835 21.1045ZM17.8734 23.9111H9.91536V20.4795H17.8734V23.9111ZM17.8836 37.2739H9.92965V33.8484H17.8836V37.2739ZM17.8856 50.7H9.91332V47.2766H17.8856V50.7ZM17.8836 64.0914C17.6836 64.1119 17.4897 64.1486 17.2958 64.1486C15.0608 64.1527 12.8259 64.1343 10.5909 64.1629C10.0256 64.1711 9.82964 64.0097 9.85821 63.4337C9.90312 62.5493 9.87046 61.6607 9.87046 60.6966H17.8836V64.0914ZM53.8916 70.9996V71.8391H20.1532V2.41253C21.3819 2.73322 22.6025 3.04778 23.821 3.37052C33.5996 5.9626 43.3742 8.55877 53.1569 11.1325C53.7447 11.2877 53.9549 11.5022 53.9549 12.1456C53.9182 31.765 53.9059 51.3823 53.8916 70.9996ZM71.8365 71.835H56.1184V23.2922H71.8365V71.835Z" fill="#161616" />
                                                    <path d="M2.08596 51.3719C2.05535 51.9458 1.60428 52.2829 1.02666 52.2481C0.420474 52.2114 0.053086 51.8396 0.0306345 51.2084C0.0122652 50.6753 0.0285935 50.1422 0.0285935 49.6091C0.0306345 49.0759 0.00614203 48.5428 0.0367577 48.0117C0.0694143 47.4214 0.412309 47.0721 1.00217 47.0354C1.59203 46.9966 2.04718 47.305 2.07984 47.879C2.14719 49.0392 2.14515 50.2096 2.08596 51.3719Z" fill="#161616" />
                                                    <path d="M2.10018 40.7686C2.06548 41.3753 1.62462 41.745 1.00414 41.698C0.395908 41.651 0.0448492 41.265 0.0285209 40.6338C0.0183157 40.1252 0.0264798 39.6145 0.0264798 39.1059C0.0285209 38.5973 0.0121926 38.0887 0.032603 37.5801C0.0570955 36.953 0.406114 36.5731 1.02659 36.5404C1.65727 36.5077 2.07364 36.8876 2.10426 37.4902C2.16141 38.581 2.16141 39.6779 2.10018 40.7686Z" fill="#161616" />
                                                    <path d="M33.3649 20.704C33.3649 19.7358 33.371 18.7676 33.3629 17.7994C33.3527 16.8618 33.0016 16.5003 32.079 16.4962C30.1441 16.486 28.2092 16.488 26.2743 16.4962C25.3885 16.5003 24.9885 16.8638 24.9803 17.7299C24.9619 19.6908 24.964 21.6538 24.9803 23.6147C24.9864 24.4951 25.3763 24.8852 26.2437 24.8913C28.2031 24.9056 30.1625 24.9056 32.1219 24.8913C32.9873 24.8852 33.3527 24.493 33.3629 23.6086C33.3731 22.6404 33.3649 21.6722 33.3649 20.704ZM31.2136 22.7098H27.154V18.6838H31.2136V22.7098Z" fill="#161616" />
                                                    <path d="M49.0361 17.6503C49.0259 16.8721 48.6136 16.5023 47.8196 16.4983C45.8337 16.486 43.8498 16.484 41.8638 16.4983C41.0352 16.5023 40.6719 16.8823 40.6617 17.7259C40.6474 18.6941 40.6576 19.6623 40.6576 20.6305C40.6576 21.5987 40.6494 22.6179 40.6596 23.6107C40.6698 24.4951 41.0352 24.8852 41.9006 24.8914C43.862 24.9057 45.8214 24.9057 47.7808 24.8914C48.6197 24.8852 49.0299 24.5074 49.0381 23.6883C49.0606 21.6763 49.0626 19.6623 49.0361 17.6503ZM46.8685 22.7364H42.8354V18.6798H46.8685V22.7364Z" fill="#161616" />
                                                    <path d="M33.3649 33.8054C33.3649 32.8372 33.3731 31.869 33.3629 30.9028C33.3527 29.9959 33.0098 29.6364 32.1301 29.6323C30.1707 29.6221 28.2113 29.6221 26.2519 29.6323C25.3701 29.6364 24.9864 30 24.9803 30.8803C24.964 32.8412 24.9619 34.8022 24.9803 36.7631C24.9885 37.5985 25.3742 38.0091 26.1906 38.0193C28.1766 38.0438 30.1605 38.0418 32.1464 38.0193C32.9812 38.0111 33.3486 37.6169 33.3608 36.7855C33.3751 35.7928 33.3649 34.7981 33.3649 33.8054ZM31.2034 35.8664H27.1377V31.7852H31.2034V35.8664Z" fill="#161616" />
                                                    <path d="M49.0381 30.7965C49.0299 30.006 48.6299 29.6384 47.838 29.6322C45.8541 29.62 43.8681 29.622 41.8843 29.6322C41.0311 29.6363 40.6739 29.9897 40.6617 30.8312C40.6474 31.826 40.6576 32.8187 40.6576 33.8114C40.6576 34.8041 40.6494 35.7478 40.6596 36.716C40.6698 37.6107 41.0188 38.011 41.8822 38.0213C43.8661 38.0417 45.852 38.0417 47.8359 38.0213C48.6217 38.0131 49.0299 37.6107 49.0381 36.8345C49.0606 34.8225 49.0606 32.8105 49.0381 30.7986V30.7965ZM46.8685 35.8418H42.8068V31.8035H46.8685V35.8418Z" fill="#161616" />
                                                    <path d="M49.0381 43.9326C49.0299 43.1421 48.6401 42.7622 47.8482 42.754C45.8377 42.7356 43.8273 42.7356 41.8189 42.7561C41.0107 42.7642 40.6739 43.1319 40.6617 43.9469C40.6474 44.9396 40.6576 45.9323 40.6576 46.925C40.6576 47.9178 40.6474 48.9125 40.6617 49.9052C40.6719 50.7223 41.0066 51.1165 41.7944 51.1267C43.8294 51.1512 45.8663 51.1512 47.9012 51.1247C48.6421 51.1145 49.0299 50.7161 49.0381 49.9665C49.0606 47.9545 49.0606 45.9425 49.0381 43.9326ZM46.8766 48.9799H42.8027V44.911H46.8766V48.9799Z" fill="#161616" />
                                                    <path d="M33.3588 43.8999C33.3445 43.1401 32.9955 42.7663 32.2321 42.7581C30.1972 42.7377 28.1623 42.7377 26.1274 42.7581C25.3803 42.7663 24.9926 43.1503 24.9844 43.902C24.9619 45.914 24.9619 47.9239 24.9823 49.9359C24.9905 50.7264 25.3763 51.1186 26.1661 51.1288C28.1766 51.1512 30.187 51.1512 32.1954 51.1267C33.0036 51.1186 33.3465 50.7407 33.3608 49.9338C33.3751 48.9411 33.3629 47.9484 33.3629 46.9557C33.3629 45.963 33.3772 44.9192 33.3588 43.8999ZM31.2075 48.9922H27.1336V44.8988H31.2075V48.9922Z" fill="#161616" />
                                                    <path d="M33.3629 60.0755C33.3629 59.7834 33.3649 59.4913 33.3669 59.1992C33.369 58.4986 33.371 57.7959 33.3608 57.0953C33.3506 56.2762 33.0138 55.882 32.228 55.8718C30.1931 55.8473 28.1582 55.8473 26.1233 55.8738C25.3783 55.884 24.9926 56.2803 24.9844 57.0299C24.9619 59.0399 24.9619 61.0519 24.9823 63.0638C24.9905 63.8523 25.3803 64.2363 26.1702 64.2445C28.1807 64.2628 30.1911 64.2629 32.1995 64.2424C33.0057 64.2343 33.3465 63.8645 33.3608 63.0536C33.371 62.3734 33.3669 61.6953 33.3649 61.0171C33.3629 60.7026 33.3629 60.388 33.3629 60.0755ZM31.2075 62.1018H27.1336V58.0186H31.2075V62.1018Z" fill="#161616" />
                                                    <path d="M49.04 57.0647C49.0319 56.2742 48.6441 55.88 47.8583 55.8718C45.8479 55.8473 43.8374 55.8473 41.829 55.8698C41.0187 55.88 40.6759 56.2558 40.6616 57.0606C40.6452 58.0533 40.6575 59.046 40.6575 60.0387C40.6575 61.0315 40.6473 62.0242 40.6616 63.0169C40.6718 63.8727 41.0106 64.2363 41.8617 64.2445C43.8456 64.2629 45.8295 64.2629 47.8134 64.2445C48.6502 64.2384 49.0319 63.8584 49.04 63.023C49.0584 61.0376 49.0605 59.0501 49.04 57.0647ZM46.8867 62.1018H42.8149V58.0186H46.8867V62.1018Z" fill="#161616" />
                                                    <path d="M69.279 50.5854C69.2709 49.6867 68.9259 49.3537 68.0177 49.3476C66.6685 49.3353 65.3194 49.3435 63.9703 49.3435C62.6211 49.3435 61.221 49.3333 59.8453 49.3476C59.0269 49.3578 58.6656 49.6907 58.6534 50.5017C58.6289 52.0561 58.6309 53.6105 58.6534 55.1629C58.6636 56.0024 59.0432 56.3824 59.878 56.3864C62.6028 56.4007 65.3255 56.4007 68.0503 56.3864C68.8871 56.3824 69.2709 55.9984 69.279 55.1711C69.2953 53.6432 69.2933 52.1153 69.2811 50.5854H69.279ZM67.1502 54.2151H60.7434C60.7434 53.4206 60.723 52.6382 60.7618 51.86C60.7699 51.717 61.0189 51.4699 61.1598 51.4678C63.1314 51.4413 65.1051 51.4494 67.1502 51.4494V54.2151Z" fill="#161616" />
                                                    <path d="M69.279 61.2132C69.2729 60.2695 68.9239 59.9202 67.9911 59.9182C65.3174 59.912 62.6436 59.912 59.9699 59.9182C59.0146 59.9182 58.6595 60.2491 58.6473 61.1826C58.6309 62.6859 58.6309 64.1893 58.6493 65.6927C58.6595 66.6139 59.0269 66.9509 59.9801 66.957C61.3047 66.9652 62.6273 66.9591 63.9519 66.9591C65.2766 66.9591 66.5992 66.9652 67.9238 66.957C68.9178 66.9529 69.2729 66.6159 69.279 65.6457C69.2913 64.1689 69.2913 62.69 69.279 61.2132ZM67.1196 64.798H60.7985V62.0976H67.1196V64.798Z" fill="#161616" />
                                                    <path d="M69.279 29.4484C69.2708 28.5272 68.9096 28.1656 67.9646 28.1615C65.2928 28.1493 62.6191 28.1493 59.9474 28.1615C59.0166 28.1677 58.6574 28.5353 58.6472 29.4709C58.6309 30.9211 58.635 32.3734 58.6452 33.8257C58.6533 34.9144 58.9615 35.2086 60.0821 35.2167C61.3802 35.2249 62.6783 35.2188 63.9764 35.2167C65.3255 35.2167 66.6746 35.231 68.0238 35.2127C68.9341 35.2004 69.2708 34.8593 69.279 33.9585C69.2912 32.4551 69.2912 30.9518 69.279 29.4484ZM67.1563 32.7023C67.1482 32.8453 66.8971 33.0904 66.7563 33.0924C64.903 33.119 63.0477 33.121 61.1944 33.0924C61.0414 33.0904 60.7719 32.8187 60.7638 32.6594C60.7168 31.9057 60.7434 31.1458 60.7434 30.3349H67.1747C67.1747 31.1438 67.1951 31.924 67.1563 32.7023Z" fill="#161616" />
                                                    <path d="M69.279 40.0475C69.2728 39.1018 68.9401 38.7648 67.9809 38.7607C65.3091 38.7484 62.6354 38.7484 59.9636 38.7586C58.9717 38.7648 58.6533 39.0998 58.6451 40.1129C58.6349 41.5652 58.6329 43.0175 58.6472 44.4678C58.6553 45.4503 59.0084 45.8016 59.9902 45.8118C61.3128 45.8261 62.6374 45.8159 63.96 45.8159C65.2826 45.8159 66.6072 45.8261 67.9298 45.8118C68.9177 45.8016 69.2728 45.4503 69.279 44.48C69.2892 43.0032 69.2912 41.5243 69.279 40.0475ZM67.1767 43.6282H60.7433C60.7433 42.8153 60.7168 42.0554 60.7637 41.2997C60.7739 41.1444 61.0515 40.883 61.2087 40.8809C63.0375 40.8503 64.8662 40.8482 66.693 40.883C66.8583 40.8871 67.142 41.1853 67.1563 41.3609C67.2073 42.0922 67.1767 42.8275 67.1767 43.6282Z" fill="#161616" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_38_79">
                                                        <rect width="74" height="74" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                            <p>
                                                Commercial
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>



                            <div class=" col-sm-3 col-6">
                                <div class="card types-btn">
                                    <div>
                                        <input type="radio"  {{$property->type == 'rent' ? 'checked' : ''}}  value="rent" name="type" id="rent" >
                                        <label for="rent">
                                            <div class="type-checked">
                                            </div>
                                            <!-- <img width="150px" class="elite-logo" src="{{asset('management/images/elite-logo.png')}}" alt=""> -->
                                            <svg width="54" height="54" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_38_60)">
                                                    <path d="M68.8086 61.5489C69.2168 60.9237 69.6562 60.3328 70.0114 59.6951C72.0088 56.1158 70.2981 51.2798 66.484 49.7699C65.92 49.5479 65.7424 49.2822 65.7424 48.682C65.7642 40.8294 65.758 32.9767 65.758 25.1209V24.2456C66.5058 24.2456 67.1945 24.255 67.8831 24.2425C69.597 24.2175 70.5162 22.8202 69.7933 21.254C66.7208 14.6018 63.6235 7.9589 60.5324 1.3129C60.065 0.303184 59.2423 -4.37988e-05 58.1797 -4.37988e-05C44.9116 0.0155865 31.6434 0.00933437 18.3753 0.00933437C17.724 0.00933437 17.0728 0.0405949 16.4247 0.00308226C15.2624 -0.0625649 14.5332 0.471991 14.044 1.50672C11.9251 5.97072 9.78434 10.4254 7.64985 14.8831C6.67141 16.9276 5.68362 18.9689 4.71141 21.0164C3.83269 22.8639 4.7083 24.2363 6.76489 24.2425H8.44444C8.46002 24.5583 8.48184 24.7927 8.48184 25.0303C8.48184 32.9079 8.48184 40.7825 8.48184 48.6601C8.48495 49.0853 8.48184 49.4073 7.96457 49.6073C3.09107 51.5111 1.64522 57.2443 5.00121 61.28C5.04171 61.3301 5.07911 61.3832 5.08534 61.3988C4.09443 61.9709 3.04744 62.4429 2.15313 63.1182C0.891133 64.0685 0.324012 65.4908 -0.00317383 67.007V72.5182C0.644965 73.6248 1.59848 73.9968 2.87294 73.9968C25.751 73.9718 48.6259 73.9781 71.5009 73.9781C73.4048 73.9781 73.9781 73.3966 73.9812 71.4647C73.9812 70.4488 73.9439 69.4328 73.9875 68.4199C74.1308 65.2376 72.47 62.346 68.8055 61.5458L68.8086 61.5489ZM66.9421 56.494C66.8922 58.3072 65.4059 59.6857 63.583 59.617C61.8318 59.5513 60.4732 58.0602 60.5292 56.2596C60.5853 54.5246 62.0499 53.1335 63.7824 53.1679C65.5897 53.2023 66.9951 54.6809 66.9421 56.494ZM9.86225 19.494C12.2242 14.558 14.5955 9.62508 16.9419 4.67966C17.1787 4.18262 17.4374 3.97943 18.017 3.97943C30.8987 3.99818 43.7805 3.99818 56.6622 3.98255C57.192 3.98255 57.4631 4.13573 57.6905 4.63277C59.9777 9.6032 62.2929 14.5611 64.5988 19.5253C64.6892 19.716 64.7733 19.9129 64.9042 20.2068C64.5801 20.2224 64.3308 20.2474 64.0815 20.2474C59.3389 20.2505 54.5963 20.2412 49.8537 20.2599C49.3457 20.2631 49.0186 20.1067 48.6976 19.7129C45.5847 15.8991 42.453 12.104 39.3276 8.30276C39.2497 8.21211 39.1749 8.1152 39.097 8.02454C37.9503 6.66158 36.6696 6.65846 35.5323 8.01204C32.2417 11.929 28.9605 15.8491 25.6513 19.7473C25.4363 20.0005 25.025 20.2255 24.7071 20.2287C19.8679 20.2599 15.0255 20.2505 10.1863 20.2474C10.0025 20.2474 9.81551 20.2193 9.56622 20.1974C9.6784 19.9254 9.76253 19.7035 9.86225 19.494ZM10.4418 53.1648C12.2149 53.1773 13.6451 54.6184 13.6451 56.3909C13.6451 58.1634 12.2211 59.6138 10.4512 59.6201C8.67191 59.6295 7.23541 58.2134 7.21672 56.4346C7.19802 54.6215 8.64387 53.1554 10.4418 53.1648ZM22.6349 69.9486H4.05704C4.05704 69.0389 3.98226 68.148 4.07885 67.2758C4.17234 66.4349 5.08846 65.694 6.00769 65.5534C6.29125 65.5096 6.58416 65.5002 6.87084 65.5002C11.8783 65.4971 16.8858 65.4971 21.8933 65.5002C22.127 65.5002 22.3638 65.519 22.6349 65.5346V69.9486ZM39.3463 70.1955H34.6941C34.6723 70.0549 34.6411 69.9423 34.6411 69.8298C34.638 66.5725 34.6286 63.3151 34.6442 60.0609C34.6504 58.8355 35.2425 57.9602 36.2178 57.6257C37.6948 57.1193 39.2404 58.1133 39.3121 59.7045C39.3837 61.3426 39.3432 62.9869 39.3463 64.6249C39.3494 66.4568 39.3463 68.2887 39.3463 70.1955ZM47.0897 63.9747V69.9517H43.3473V69.1702C43.3473 66.1754 43.3691 63.1776 43.3411 60.1828C43.3162 57.4756 42.2006 55.3905 39.7452 54.1245C36.0402 52.2176 31.1885 54.7466 30.7834 58.9011C30.5684 61.0831 30.665 63.2932 30.6401 65.4877C30.6214 66.9601 30.637 68.4325 30.637 69.9673H26.9289C26.9164 69.686 26.8977 69.4328 26.8946 69.1796C26.8946 67.3665 26.9008 65.5534 26.8915 63.7434C26.8852 62.296 26.0969 61.5051 24.651 61.4989C21.9089 61.4895 19.1637 61.4989 16.4184 61.4989H15.8139C16.3249 60.4329 16.9544 59.4263 17.3003 58.3322C18.3691 54.931 16.4807 51.0672 13.1715 49.773C12.6075 49.5511 12.4299 49.2854 12.4299 48.682C12.4517 40.8294 12.4455 32.9767 12.4455 25.1241V24.2488H13.2743C17.4405 24.2488 21.6066 24.2331 25.7728 24.2582C26.6952 24.2644 27.3776 23.9518 27.9634 23.2453C30.8987 19.7222 33.8527 16.2179 36.8005 12.7074C36.9376 12.5448 37.081 12.3823 37.2866 12.1447C37.4705 12.3573 37.6418 12.5386 37.8039 12.7324C40.6395 16.1804 43.4876 19.616 46.2982 23.0828C46.962 23.9018 47.7098 24.2769 48.7755 24.2644C52.8201 24.2238 56.8648 24.2488 60.9094 24.2488H61.7819V25.0897C61.7819 32.9423 61.7757 40.795 61.7975 48.6476C61.7975 49.2291 61.623 49.4729 61.0808 49.6792C56.5532 51.3861 55.0512 57.1349 58.1237 60.8987C58.2545 61.0581 58.3667 61.23 58.5661 61.4989H57.1733C54.6461 61.4989 52.1159 61.4957 49.5888 61.4989C47.9155 61.502 47.0928 62.3241 47.0897 63.9747ZM69.9865 69.958H51.1094V65.5377C51.3836 65.5252 51.636 65.5002 51.8916 65.5002C57.0891 65.4971 62.2836 65.4971 67.478 65.5002C69.2542 65.5002 69.9615 66.213 69.9865 68.0011C69.9927 68.6263 69.9865 69.2484 69.9865 69.958Z" fill="#BC9C5B" />
                                                    <path d="M29.8954 34.9211C29.858 36.1153 29.0323 36.9749 27.9292 36.9906C26.8261 37.0093 25.9505 36.1809 25.91 34.9774C25.8633 33.5832 25.8664 32.1858 25.9069 30.7885C25.9443 29.5881 26.8137 28.744 27.9074 28.7503C29.0323 28.7565 29.8674 29.6412 29.8986 30.876C29.9141 31.5481 29.8986 32.2233 29.8986 32.8986C29.8986 33.5738 29.9141 34.249 29.8923 34.9211H29.8954Z" fill="#BC9C5B" />
                                                    <path d="M39.0784 35.1525C39.0223 36.281 38.1093 37.0251 37.0561 36.9907C35.9841 36.9563 35.1646 36.106 35.1241 34.9619C35.1023 34.2616 35.121 33.5645 35.121 32.8643C35.121 32.164 35.1023 31.4669 35.1272 30.7698C35.1677 29.6319 35.9997 28.7816 37.0685 28.7504C38.1093 28.7222 39.0285 29.4913 39.0815 30.6073C39.1532 32.1203 39.1532 33.6427 39.0784 35.1525Z" fill="#BC9C5B" />
                                                    <path d="M29.8922 47.2253C29.8454 48.3945 29.0321 49.2073 27.9353 49.2229C26.8353 49.2416 25.9628 48.4632 25.9161 47.291C25.86 45.8436 25.86 44.3931 25.9161 42.9458C25.9628 41.7735 26.8353 41.0014 27.9415 41.0201C29.0384 41.0389 29.8485 41.8516 29.8953 43.0239C29.9202 43.7241 29.8984 44.4244 29.8984 45.1246C29.8984 45.8249 29.9233 46.5251 29.8922 47.2253Z" fill="#BC9C5B" />
                                                    <path d="M39.0908 47.3348C39.0347 48.5102 38.1467 49.2604 37.0374 49.2229C35.9467 49.1823 35.1584 48.3539 35.1241 47.1785C35.1023 46.4782 35.121 45.778 35.121 45.0778C35.121 44.3775 35.1023 43.7273 35.1241 43.049C35.1615 41.8798 35.9592 41.0514 37.0498 41.0233C38.1623 40.992 39.041 41.7423 39.0908 42.9208C39.1563 44.39 39.1563 45.8655 39.0908 47.3348Z" fill="#BC9C5B" />
                                                    <path d="M20.6688 32.8799C20.6688 33.5801 20.6844 34.2804 20.6657 34.9806C20.6346 36.1216 19.7932 36.975 18.7151 36.9938C17.6525 37.0094 16.7675 36.2373 16.727 35.1119C16.6678 33.6176 16.6678 32.1171 16.727 30.6229C16.7706 29.51 17.6774 28.7222 18.7275 28.7504C19.8026 28.7785 20.6346 29.6382 20.6657 30.7792C20.6844 31.4763 20.6688 32.1796 20.6688 32.8799Z" fill="#BC9C5B" />
                                                    <path d="M20.6689 45.1434C20.6689 45.8437 20.6844 46.5439 20.6657 47.2441C20.6315 48.3695 19.84 49.1792 18.7712 49.2229C17.6556 49.2667 16.7676 48.5102 16.7239 47.3442C16.6678 45.8499 16.6678 44.3494 16.7302 42.8551C16.7769 41.7298 17.6525 40.9951 18.7431 41.0202C19.8151 41.0483 20.6252 41.8548 20.6626 42.9708C20.6876 43.6929 20.6689 44.4182 20.6689 45.1434Z" fill="#BC9C5B" />
                                                    <path d="M57.5222 34.9649C57.5035 36.1278 56.684 36.9687 55.5965 36.9937C54.481 37.0188 53.6209 36.181 53.5773 34.9837C53.5493 34.2835 53.5711 33.5832 53.5711 32.883H53.5742C53.5742 32.1577 53.5493 31.4325 53.5804 30.7104C53.6303 29.5694 54.5028 28.7347 55.5778 28.7503C56.656 28.766 57.5035 29.6163 57.5222 30.7635C57.5472 32.164 57.544 33.5645 57.5222 34.9649Z" fill="#BC9C5B" />
                                                    <path d="M48.3081 32.8861C48.3081 33.6113 48.3392 34.3366 48.2987 35.0587C48.2364 36.2153 47.3764 37.0219 46.2857 36.9906C45.2045 36.9625 44.3725 36.1122 44.3569 34.9618C44.3351 33.5613 44.332 32.1608 44.3569 30.7604C44.3756 29.6225 45.2356 28.7659 46.3107 28.7503C47.3826 28.7316 48.2457 29.56 48.3018 30.7135C48.3392 31.4356 48.3081 32.1608 48.3081 32.8861Z" fill="#BC9C5B" />
                                                    <path d="M48.2894 47.3753C48.2489 48.4882 47.3701 49.2478 46.2858 49.2228C45.2138 49.2009 44.3974 48.3975 44.3569 47.2847C44.332 46.5594 44.3538 45.8373 44.3538 45.1121C44.3538 44.3868 44.332 43.6616 44.36 42.9394C44.4005 41.8297 45.2294 41.0326 46.3045 41.0201C47.392 41.0075 48.2551 41.7641 48.2894 42.8863C48.3392 44.3806 48.3392 45.8811 48.2894 47.3753Z" fill="#BC9C5B" />
                                                    <path d="M57.5161 47.3317C57.4693 48.4383 56.628 49.2292 55.5499 49.226C54.4966 49.226 53.6304 48.4664 53.5961 47.3973C53.5493 45.878 53.5493 44.3557 53.5961 42.8364C53.6304 41.7673 54.4966 41.017 55.553 41.0202C56.6374 41.0202 57.4538 41.8079 57.5223 42.9145C57.5254 42.9646 57.5285 43.0115 57.5285 43.0583C57.5317 43.7586 57.5285 44.4588 57.5285 45.1591H57.5223C57.5223 45.8843 57.5472 46.6095 57.5161 47.3317Z" fill="#BC9C5B" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_38_60">
                                                        <rect width="74" height="74" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <p>
                                                For Rent
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-sm-3 col-6">
                                <div class="card types-btn">
                                    <div>
                                        <input type="radio" {{$property->type == 'sale' ? 'checked' : ''}}  value="sale" name="type" id="sale">
                                        <label for="sale">
                                            <div class="type-checked">
                                            </div>
                                            <!-- <img width="150px" class="elite-logo" src="{{asset('management/images/elite-logo.png')}}" alt=""> -->
                                            <svg width="74" height="74" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_38_79)">
                                                    <path d="M72.3835 21.1045H56.0429C56.0429 17.6852 56.0449 14.3986 56.0429 11.1141C56.0409 9.87013 55.9 9.67812 54.7019 9.35947C43.0558 6.27921 31.4075 3.19894 19.7613 0.120709C18.4694 -0.220408 17.9856 0.143178 17.9816 1.46475C17.9754 4.19165 17.9795 6.9165 17.9795 9.6434V10.536H17.0692C11.9013 10.536 6.73338 10.534 1.56546 10.536C0.32859 10.536 0.0244744 10.8363 0.0244744 12.0537C0.0244744 16.9192 0.0244744 21.7868 0.0244744 26.6523C0.0244744 27.8002 0.0203923 28.9461 0.0285564 30.0921C0.0346796 30.7498 0.353082 31.1706 1.03071 31.1992C1.71242 31.2298 2.04511 30.8111 2.12879 30.1758C2.1594 29.9511 2.14308 29.7183 2.14308 29.4895V12.7135H17.8877V18.3061H17.0202C14.3975 18.3061 11.7768 18.3021 9.15405 18.3082C8.09475 18.3082 7.78247 18.6187 7.77635 19.6727C7.76614 21.2782 7.77023 22.8837 7.77431 24.4871C7.77635 25.7801 8.05393 26.0599 9.34591 26.062C11.9176 26.0681 14.4893 26.062 17.059 26.0661C17.3305 26.0661 17.5999 26.0906 17.8795 26.1049V31.6853H16.9978C14.3995 31.6873 11.8033 31.6812 9.20712 31.6894C8.11108 31.6914 7.78247 32.0203 7.77635 33.0967C7.76614 34.7268 7.76819 36.3588 7.77431 37.9888C7.78043 39.1388 8.08251 39.4432 9.21733 39.4432C11.8401 39.4473 14.4608 39.4452 17.0835 39.4452H17.8897V45.0951H17.0223C14.3995 45.0951 11.7768 45.093 9.15405 45.0971C8.12537 45.0992 7.78247 45.4362 7.77635 46.4698C7.76614 48.0998 7.77023 49.7298 7.77431 51.3618C7.77839 52.5364 8.10292 52.8652 9.26427 52.8673C11.8605 52.8713 14.4567 52.8693 17.0549 52.8693H17.8897V58.5069H17.0264C14.4036 58.5069 11.7809 58.5028 9.15813 58.509C8.09271 58.5131 7.78247 58.8154 7.77635 59.8694C7.76614 61.5259 7.76819 63.1804 7.77635 64.837C7.78043 65.94 8.08047 66.2362 9.19283 66.2403C11.8135 66.2444 14.4363 66.2403 17.059 66.2403H17.8877V71.8432H2.14103V70.9077C2.14103 67.0083 2.14308 63.111 2.13695 59.2116C2.13695 58.9093 2.13287 58.5948 2.05327 58.3068C1.90223 57.7655 1.46341 57.4468 0.95723 57.6163C0.595966 57.7369 0.308179 58.1474 0.0530489 58.4783C-0.0469621 58.6091 0.0244744 58.8746 0.0244744 59.0789C0.0244744 63.5379 0.0244744 67.9969 0.0244744 72.4539C0.0244744 73.7367 0.291851 74.0002 1.60016 74.0002H72.4018C73.7449 74.0002 73.9979 73.7449 73.9979 72.3967C73.9979 55.8352 74 39.2736 73.9979 22.7121C73.9979 21.3946 73.7081 21.1045 72.3835 21.1045ZM17.8734 23.9111H9.91536V20.4795H17.8734V23.9111ZM17.8836 37.2739H9.92965V33.8484H17.8836V37.2739ZM17.8856 50.7H9.91332V47.2766H17.8856V50.7ZM17.8836 64.0914C17.6836 64.1119 17.4897 64.1486 17.2958 64.1486C15.0608 64.1527 12.8259 64.1343 10.5909 64.1629C10.0256 64.1711 9.82964 64.0097 9.85821 63.4337C9.90312 62.5493 9.87046 61.6607 9.87046 60.6966H17.8836V64.0914ZM53.8916 70.9996V71.8391H20.1532V2.41253C21.3819 2.73322 22.6025 3.04778 23.821 3.37052C33.5996 5.9626 43.3742 8.55877 53.1569 11.1325C53.7447 11.2877 53.9549 11.5022 53.9549 12.1456C53.9182 31.765 53.9059 51.3823 53.8916 70.9996ZM71.8365 71.835H56.1184V23.2922H71.8365V71.835Z" fill="#161616" />
                                                    <path d="M2.08596 51.3719C2.05535 51.9458 1.60428 52.2829 1.02666 52.2481C0.420474 52.2114 0.053086 51.8396 0.0306345 51.2084C0.0122652 50.6753 0.0285935 50.1422 0.0285935 49.6091C0.0306345 49.0759 0.00614203 48.5428 0.0367577 48.0117C0.0694143 47.4214 0.412309 47.0721 1.00217 47.0354C1.59203 46.9966 2.04718 47.305 2.07984 47.879C2.14719 49.0392 2.14515 50.2096 2.08596 51.3719Z" fill="#161616" />
                                                    <path d="M2.10018 40.7686C2.06548 41.3753 1.62462 41.745 1.00414 41.698C0.395908 41.651 0.0448492 41.265 0.0285209 40.6338C0.0183157 40.1252 0.0264798 39.6145 0.0264798 39.1059C0.0285209 38.5973 0.0121926 38.0887 0.032603 37.5801C0.0570955 36.953 0.406114 36.5731 1.02659 36.5404C1.65727 36.5077 2.07364 36.8876 2.10426 37.4902C2.16141 38.581 2.16141 39.6779 2.10018 40.7686Z" fill="#161616" />
                                                    <path d="M33.3649 20.704C33.3649 19.7358 33.371 18.7676 33.3629 17.7994C33.3527 16.8618 33.0016 16.5003 32.079 16.4962C30.1441 16.486 28.2092 16.488 26.2743 16.4962C25.3885 16.5003 24.9885 16.8638 24.9803 17.7299C24.9619 19.6908 24.964 21.6538 24.9803 23.6147C24.9864 24.4951 25.3763 24.8852 26.2437 24.8913C28.2031 24.9056 30.1625 24.9056 32.1219 24.8913C32.9873 24.8852 33.3527 24.493 33.3629 23.6086C33.3731 22.6404 33.3649 21.6722 33.3649 20.704ZM31.2136 22.7098H27.154V18.6838H31.2136V22.7098Z" fill="#161616" />
                                                    <path d="M49.0361 17.6503C49.0259 16.8721 48.6136 16.5023 47.8196 16.4983C45.8337 16.486 43.8498 16.484 41.8638 16.4983C41.0352 16.5023 40.6719 16.8823 40.6617 17.7259C40.6474 18.6941 40.6576 19.6623 40.6576 20.6305C40.6576 21.5987 40.6494 22.6179 40.6596 23.6107C40.6698 24.4951 41.0352 24.8852 41.9006 24.8914C43.862 24.9057 45.8214 24.9057 47.7808 24.8914C48.6197 24.8852 49.0299 24.5074 49.0381 23.6883C49.0606 21.6763 49.0626 19.6623 49.0361 17.6503ZM46.8685 22.7364H42.8354V18.6798H46.8685V22.7364Z" fill="#161616" />
                                                    <path d="M33.3649 33.8054C33.3649 32.8372 33.3731 31.869 33.3629 30.9028C33.3527 29.9959 33.0098 29.6364 32.1301 29.6323C30.1707 29.6221 28.2113 29.6221 26.2519 29.6323C25.3701 29.6364 24.9864 30 24.9803 30.8803C24.964 32.8412 24.9619 34.8022 24.9803 36.7631C24.9885 37.5985 25.3742 38.0091 26.1906 38.0193C28.1766 38.0438 30.1605 38.0418 32.1464 38.0193C32.9812 38.0111 33.3486 37.6169 33.3608 36.7855C33.3751 35.7928 33.3649 34.7981 33.3649 33.8054ZM31.2034 35.8664H27.1377V31.7852H31.2034V35.8664Z" fill="#161616" />
                                                    <path d="M49.0381 30.7965C49.0299 30.006 48.6299 29.6384 47.838 29.6322C45.8541 29.62 43.8681 29.622 41.8843 29.6322C41.0311 29.6363 40.6739 29.9897 40.6617 30.8312C40.6474 31.826 40.6576 32.8187 40.6576 33.8114C40.6576 34.8041 40.6494 35.7478 40.6596 36.716C40.6698 37.6107 41.0188 38.011 41.8822 38.0213C43.8661 38.0417 45.852 38.0417 47.8359 38.0213C48.6217 38.0131 49.0299 37.6107 49.0381 36.8345C49.0606 34.8225 49.0606 32.8105 49.0381 30.7986V30.7965ZM46.8685 35.8418H42.8068V31.8035H46.8685V35.8418Z" fill="#161616" />
                                                    <path d="M49.0381 43.9326C49.0299 43.1421 48.6401 42.7622 47.8482 42.754C45.8377 42.7356 43.8273 42.7356 41.8189 42.7561C41.0107 42.7642 40.6739 43.1319 40.6617 43.9469C40.6474 44.9396 40.6576 45.9323 40.6576 46.925C40.6576 47.9178 40.6474 48.9125 40.6617 49.9052C40.6719 50.7223 41.0066 51.1165 41.7944 51.1267C43.8294 51.1512 45.8663 51.1512 47.9012 51.1247C48.6421 51.1145 49.0299 50.7161 49.0381 49.9665C49.0606 47.9545 49.0606 45.9425 49.0381 43.9326ZM46.8766 48.9799H42.8027V44.911H46.8766V48.9799Z" fill="#161616" />
                                                    <path d="M33.3588 43.8999C33.3445 43.1401 32.9955 42.7663 32.2321 42.7581C30.1972 42.7377 28.1623 42.7377 26.1274 42.7581C25.3803 42.7663 24.9926 43.1503 24.9844 43.902C24.9619 45.914 24.9619 47.9239 24.9823 49.9359C24.9905 50.7264 25.3763 51.1186 26.1661 51.1288C28.1766 51.1512 30.187 51.1512 32.1954 51.1267C33.0036 51.1186 33.3465 50.7407 33.3608 49.9338C33.3751 48.9411 33.3629 47.9484 33.3629 46.9557C33.3629 45.963 33.3772 44.9192 33.3588 43.8999ZM31.2075 48.9922H27.1336V44.8988H31.2075V48.9922Z" fill="#161616" />
                                                    <path d="M33.3629 60.0755C33.3629 59.7834 33.3649 59.4913 33.3669 59.1992C33.369 58.4986 33.371 57.7959 33.3608 57.0953C33.3506 56.2762 33.0138 55.882 32.228 55.8718C30.1931 55.8473 28.1582 55.8473 26.1233 55.8738C25.3783 55.884 24.9926 56.2803 24.9844 57.0299C24.9619 59.0399 24.9619 61.0519 24.9823 63.0638C24.9905 63.8523 25.3803 64.2363 26.1702 64.2445C28.1807 64.2628 30.1911 64.2629 32.1995 64.2424C33.0057 64.2343 33.3465 63.8645 33.3608 63.0536C33.371 62.3734 33.3669 61.6953 33.3649 61.0171C33.3629 60.7026 33.3629 60.388 33.3629 60.0755ZM31.2075 62.1018H27.1336V58.0186H31.2075V62.1018Z" fill="#161616" />
                                                    <path d="M49.04 57.0647C49.0319 56.2742 48.6441 55.88 47.8583 55.8718C45.8479 55.8473 43.8374 55.8473 41.829 55.8698C41.0187 55.88 40.6759 56.2558 40.6616 57.0606C40.6452 58.0533 40.6575 59.046 40.6575 60.0387C40.6575 61.0315 40.6473 62.0242 40.6616 63.0169C40.6718 63.8727 41.0106 64.2363 41.8617 64.2445C43.8456 64.2629 45.8295 64.2629 47.8134 64.2445C48.6502 64.2384 49.0319 63.8584 49.04 63.023C49.0584 61.0376 49.0605 59.0501 49.04 57.0647ZM46.8867 62.1018H42.8149V58.0186H46.8867V62.1018Z" fill="#161616" />
                                                    <path d="M69.279 50.5854C69.2709 49.6867 68.9259 49.3537 68.0177 49.3476C66.6685 49.3353 65.3194 49.3435 63.9703 49.3435C62.6211 49.3435 61.221 49.3333 59.8453 49.3476C59.0269 49.3578 58.6656 49.6907 58.6534 50.5017C58.6289 52.0561 58.6309 53.6105 58.6534 55.1629C58.6636 56.0024 59.0432 56.3824 59.878 56.3864C62.6028 56.4007 65.3255 56.4007 68.0503 56.3864C68.8871 56.3824 69.2709 55.9984 69.279 55.1711C69.2953 53.6432 69.2933 52.1153 69.2811 50.5854H69.279ZM67.1502 54.2151H60.7434C60.7434 53.4206 60.723 52.6382 60.7618 51.86C60.7699 51.717 61.0189 51.4699 61.1598 51.4678C63.1314 51.4413 65.1051 51.4494 67.1502 51.4494V54.2151Z" fill="#161616" />
                                                    <path d="M69.279 61.2132C69.2729 60.2695 68.9239 59.9202 67.9911 59.9182C65.3174 59.912 62.6436 59.912 59.9699 59.9182C59.0146 59.9182 58.6595 60.2491 58.6473 61.1826C58.6309 62.6859 58.6309 64.1893 58.6493 65.6927C58.6595 66.6139 59.0269 66.9509 59.9801 66.957C61.3047 66.9652 62.6273 66.9591 63.9519 66.9591C65.2766 66.9591 66.5992 66.9652 67.9238 66.957C68.9178 66.9529 69.2729 66.6159 69.279 65.6457C69.2913 64.1689 69.2913 62.69 69.279 61.2132ZM67.1196 64.798H60.7985V62.0976H67.1196V64.798Z" fill="#161616" />
                                                    <path d="M69.279 29.4484C69.2708 28.5272 68.9096 28.1656 67.9646 28.1615C65.2928 28.1493 62.6191 28.1493 59.9474 28.1615C59.0166 28.1677 58.6574 28.5353 58.6472 29.4709C58.6309 30.9211 58.635 32.3734 58.6452 33.8257C58.6533 34.9144 58.9615 35.2086 60.0821 35.2167C61.3802 35.2249 62.6783 35.2188 63.9764 35.2167C65.3255 35.2167 66.6746 35.231 68.0238 35.2127C68.9341 35.2004 69.2708 34.8593 69.279 33.9585C69.2912 32.4551 69.2912 30.9518 69.279 29.4484ZM67.1563 32.7023C67.1482 32.8453 66.8971 33.0904 66.7563 33.0924C64.903 33.119 63.0477 33.121 61.1944 33.0924C61.0414 33.0904 60.7719 32.8187 60.7638 32.6594C60.7168 31.9057 60.7434 31.1458 60.7434 30.3349H67.1747C67.1747 31.1438 67.1951 31.924 67.1563 32.7023Z" fill="#161616" />
                                                    <path d="M69.279 40.0475C69.2728 39.1018 68.9401 38.7648 67.9809 38.7607C65.3091 38.7484 62.6354 38.7484 59.9636 38.7586C58.9717 38.7648 58.6533 39.0998 58.6451 40.1129C58.6349 41.5652 58.6329 43.0175 58.6472 44.4678C58.6553 45.4503 59.0084 45.8016 59.9902 45.8118C61.3128 45.8261 62.6374 45.8159 63.96 45.8159C65.2826 45.8159 66.6072 45.8261 67.9298 45.8118C68.9177 45.8016 69.2728 45.4503 69.279 44.48C69.2892 43.0032 69.2912 41.5243 69.279 40.0475ZM67.1767 43.6282H60.7433C60.7433 42.8153 60.7168 42.0554 60.7637 41.2997C60.7739 41.1444 61.0515 40.883 61.2087 40.8809C63.0375 40.8503 64.8662 40.8482 66.693 40.883C66.8583 40.8871 67.142 41.1853 67.1563 41.3609C67.2073 42.0922 67.1767 42.8275 67.1767 43.6282Z" fill="#161616" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_38_79">
                                                        <rect width="74" height="74" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                            <p>
                                                For Sale
                                            </p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card p-3">
                            <h2>Specification</h2>
                            <div class="row sit">

                                <div class=" col-sm-6">
                                    <input value="{{$property->deeds}}" type="text" placeholder="Total Deed">
                                </div>
                                <div class=" col-sm-6">
                                    <select class="form-select" name="property_type" aria-label="Default select example">
                                        <option selected="" value="">Property Type*</option>


                                        <option  value="">Any</option>
                                        <option {{$property->property_type == 'Apartment' ?  'selected' : ''}} value="Apartment">Apartment</option>
                                        <option {{$property->property_type == 'Villa' ?  'selected' : ''}}  value="Villa">Villa</option>
                                        <option {{$property->property_type == 'Townhouse' ?  'selected' : ''}}  value="Townhouse">Townhouses</option>
                                        <option {{$property->property_type == 'Hotel Apartment' ?  'selected' : ''}} value="Hotel Apartment">Hotel Apartments</option>
                                        <option {{$property->property_type == 'Duplex' ?  'selected' : ''}} value="Duplex">Duplex</option>
                                        <option {{$property->property_type == 'Penthouse' ?  'selected' : ''}}  value="Penthouse">Penthouse</option>
                                        <option {{$property->property_type == 'Mansion' ?  'selected' : ''}}  value="Mansion">Mansion</option>
                                        <option {{$property->property_type == 'Office' ?  'selected' : ''}}  value="Office">Office</option>
                                        <option {{$property->property_type == 'Residential Plot' ?  'selected' : ''}}  value="Residential Plot">Residential Plots</option>
                                        <option {{$property->property_type == 'Commercial Plot' ?  'selected' : ''}}  value="Commercial Plot">Commercial Plots</option>
                                    </select>
                                </div>
                                <div class=" col-sm-6">
                                    <div class="input-group mb-0 d-flex">
                                        <input type="text" value="{{$property->size}}"  name="size" placeholder="Size">
                                        <span class="input-group-text" id="addon-wrapping">SQFT</span>
                                    </div>
                                </div>
{{--                                <div class=" col-sm-6">--}}
{{--                                    <select name="bedrooms" class="form-select" aria-label="Default select example">--}}
{{--                                        <option selected="" value="">No Of Bedroom*</option>--}}
{{--                                        <option {{$property->bedrooms == 1 ? 'selected' : ''}} value="1">1</option>--}}
{{--                                        <option {{$property->bedrooms == 2 ?  'selected' : ''}} value="2">2</option>--}}
{{--                                        <option {{$property->bedrooms == 3 ?  'selected' : ''}} value="3">3</option>--}}
{{--                                        <option {{$property->bedrooms == 4 ?  'selected' : ''}} value="4">4</option>--}}
{{--                                        <option {{$property->bedrooms == 5 ?  'selected' : ''}} value="5">5</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class=" col-sm-6">--}}
{{--                                    <select name="bathrooms" class="form-select" aria-label="Default select example">--}}
{{--                                        <option selected="" value="">No Of Bathroom*</option>--}}
{{--                                        <option {{$property->bathrooms == 1 ? 'selected' : ''}} value="1">1</option>--}}
{{--                                        <option {{$property->bathrooms == 2 ?  'selected' : ''}} value="2">2</option>--}}
{{--                                        <option {{$property->bathrooms == 3 ?  'selected' : ''}} value="3">3</option>--}}
{{--                                        <option {{$property->bathrooms == 4 ?  'selected' : ''}} value="4">4</option>--}}
{{--                                        <option {{$property->bathrooms == 5 ?  'selected' : ''}} value="5">5</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}


                                <div class=" col-sm-6">
                                    <div class="input-group mb-0 d-flex">
                                        <input type="text" name="bedrooms"  value="{{$property->bedrooms}}" placeholder="Example:1,2 & 3 OR 1 to 2 ">
                                        <span class="input-group-text" id="addon-wrapping">Bedrooms</span>
                                    </div>
                                </div>
                                <div class=" col-sm-6">
                                    <div class="input-group mb-0 d-flex">
                                        <input type="text" name="bathrooms" value="{{$property->bathrooms}}"  placeholder="Example:1,2 & 3 OR 1 to 2 ">
                                        <span class="input-group-text" id="addon-wrapping">Bathrooms</span>
                                    </div>
                                </div>

                                <div class=" col-sm-6">
                                    <div class="input-group mb-0 d-flex">
                                        <input type="number" name="parkings" min="0" value="{{$property->parkings}}" placeholder="0">
                                        <span class="input-group-text" id="addon-wrapping">PARKING</span>
                                    </div>
                                </div>
                                <div class=" col-sm-6">
                                    <select class="form-select" name="furnishing_type" aria-label="Default select example">
                                        <option selected value="">Furnishing Type</option>
                                        <option  {{$property->furnishing_type == 'Furnished' ?  'selected' : ''}} value="Furnished">Furnished</option>
                                        <option  {{$property->furnishing_type == 'unfurnished' ?  'selected' : ''}} value="unfurnished">unfurnished</option>
                                    </select>
                                </div>
                                <div class=" col-sm-6">
                                    <div class="input-group mb-0 d-flex">
                                        <input value="{{$property->build_up_area}}" type="text" name="build_up_area" placeholder="Build-up Aera">
                                        <span class="input-group-text" id="addon-wrapping">SQFT</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="font-weight-bold small">Completion Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="completion_status">
                                        <option value="Ready" {{ $property->completion_status == 'Ready' ? 'selected' : '' }}>Ready (Completed)</option>
                                        <option value="Off-plan" {{ $property->completion_status == 'Off-plan' ? 'selected' : '' }}>Off-plan Projects</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="font-weight-bold small">Handover Date</label>
                                    <div class="input-group mb-0 d-flex">
                                        <input type="text" value="{{ old('handover_date', $property->handover_date) }}" name="handover_date" placeholder="e.g. Q4 2027 / Immediate">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group mb-0 d-flex">
                                        <input type="text" value="{{$property->layout_type}}" name="layout_type" placeholder="ie.Type E">
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="card p-3">
                            <h2>$ Pricing & Financial Terms</h2>
                            <div class="row sit">
                                <div class=" col-sm-6 ">
                                    <div class="input-group mb-0 d-flex">
                                        <span class="headspan" id="addon-wrapping">Sale Price*</span>
                                        <input class="aedinp" value="{{$property->price}}" name="price" type="number" placeholder="AED">
                                        <span class="input-group-text" id="addon-wrapping">AED</span>
                                    </div>
                                </div>
                                <div class=" col-sm-6 ">
                                    <div class="input-group mb-0 d-flex">
                                        <span class="headspan" id="addon-wrapping">End Price</span>
                                        <input class="aedinp" value="{{$property->end_price}}" name="end_price" type="number" placeholder="AED">
                                        <span class="input-group-text" id="addon-wrapping">AED</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row sit">
                                <div class=" col-sm-6">
                                    <div class="input-group mb-0 d-flex">
                                        <input type="text" name="service_charges"  value="{{$property->service_charges}}" placeholder="Service charges">
                                        <span class="input-group-text" id="addon-wrapping">Monthly</span>
                                    </div>
                                </div>
                                <div class=" col-sm-6">
                                    <select class="form-select" name="financial_status" aria-label="Default select example">
                                        <option selected value="">Financial Status</option>
                                        <option  {{$property->financial_status == 'Mortgaged' ?  'selected' : ''}} value="Mortgaged">Mortgaged</option>
                                        <option {{$property->financial_status == 'Cash' ?  'selected' : ''}}  value="Cash">Cash</option>
                                    </select>
                                </div>
                            </div>

                            <!-- High-End Rental Terms Section -->
                            <div class="row sit mt-3 border-top pt-3">
                                <div class="col-12"><h5 class="font-weight-bold text-dark"><i class="fas fa-key text-warning mr-1"></i> High-End Rental Terms (If For Rent)</h5></div>
                                <div class="col-sm-4">
                                    <label class="font-weight-bold small">Yearly Rent (AED)</label>
                                    <input type="number" name="yearly_rent" value="{{ old('yearly_rent', $property->yearly_rent) }}" placeholder="e.g. 1200000">
                                </div>
                                <div class="col-sm-4">
                                    <label class="font-weight-bold small">Cheques / Schedule</label>
                                    <select class="form-select" name="cheques">
                                        <option value="">Select Cheques</option>
                                        <option value="1" {{ $property->cheques == 1 ? 'selected' : '' }}>1 Cheque</option>
                                        <option value="2" {{ $property->cheques == 2 ? 'selected' : '' }}>2 Cheques</option>
                                        <option value="4" {{ $property->cheques == 4 ? 'selected' : '' }}>4 Cheques</option>
                                        <option value="6" {{ $property->cheques == 6 ? 'selected' : '' }}>6 Cheques</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label class="font-weight-bold small">Security Deposit (AED)</label>
                                    <input type="number" name="deposit" value="{{ old('deposit', $property->deposit) }}" placeholder="e.g. 120000">
                                </div>
                            </div>
                        </div>
                        <div class="card p-3">
                            <h2>Description </h2>
                            <div class="row sit">
                                <div class=" col-sm-12">
                                    <label for="email_address1">   <strong>   Title  </strong></label>
                                    <input name="title"   value="{{$property->title}}" type="text" placeholder="Title">
                                </div>

                                <div class=" col-sm-6">
                                    <label for="email_address1">   <strong>  Meta Title  </strong></label>
                                    <input name="meta_title"   value="{{$property->meta_title}}" type="text" placeholder="Meta Title">
                                </div>

                                <div class=" col-sm-6">
                                    <label for="email_address1">   <strong>  Meta Description  </strong></label>
                                    <input name="meta_description"   value="{{$property->meta_description}}" type="text" placeholder="Meta Description">
                                </div>

                                <div class=" col-sm-6">
                                    <label for="email_address1">   <strong>  Meta Keyword  </strong></label>
                                    <input name="meta_tag"   value="{{$property->meta_tag}}" type="text" placeholder="Meta Keyword">
                                </div>
                                
{{--                                <div class=" col-12">--}}
{{--                                    <textarea name="description"   id="" cols="30" rows="5" placeholder="Description"> {{$property->description}}</textarea>--}}
{{--                                </div>--}}
                            </div>
                            <div class="row my-2">
                                <div class=" col-12">
                                    <label for="email_address1">   <strong>   Description  </strong></label>
                                    <textarea value="{{old('Description') }}" type="text" name="description"
                                              id="erp_order_message"  class="ckeditor form-control choices" cols="30"
                                              rows="10"
                                    > {{$property->description}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="body">
                                <h2>Select Amenities</h2>
                                <div class="row justify-content-center">
                                    <div class="col-8 text-center">
                                        <p>There are no amenities for this property</p>
                                        <select class="js-example-basic-multiple  form-select" name="amenities[]"multiple="multiple">

                                            @foreach($amenities as $amenity)

                                                @if($property->amenities == null)
                                                    <option value="{{$amenity->id}}">{{$amenity->title}}</option>
                                                @else
                                                    <option {{in_array($amenity->id,$property->amenities->pluck('id')->toArray()) ? 'selected' : ''}} value="{{$amenity->id}}">{{$amenity->title}}</option>
                                                @endif
                                            @endforeach
                                        </select>


                                        {{--                                        <div class="multiSelect">--}}
                                        {{--                                            <select multiple  name="amenities[]" class="multiSelect_field" data-placeholder="Add Browsers">--}}
                                        {{--                                               @foreach($amenities as $amenity)--}}
                                        {{--                                                <option {{in_array($amenity->id,json_decode($property->amenities)) ? 'selected' : ''}} value="{{$amenity->id}}">{{$amenity->title}}</option>--}}
                                        {{--                                                @endforeach--}}
                                        {{--                                            </select>--}}
                                        {{--                                        </div>--}}



                                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                            <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="iconX">
                                                <g stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </g>
                                            </symbol>
                                        </svg>
                                    </div>
                                </div>





                                <div class="dragdrop">

                                    <input id="SelectAmenities" class=" d-none" type="file" >
                                    <label for="SelectAmenities" style="display: none;">Upload</label>
                                    <div id="previewSelectAmenities" style="display: none;"></div>

                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{--                    <button class="btn tab-next-btn nextmedia">Next</button>--}}
                        </div>
                    </div>


                    <div class="tab-pane fade py-3" id="media" role="tabpanel" aria-labelledby="media-tab">
                        <div class="row w-100 mx-auto">
                            <div class="col">
                                <p>Please upload images In our recommended . 4:3 ratio. Any duplicate images will affect your Quality Score</p>
                                <div class="upload__box">
                                    <div class="upload__btn-box text-center">
                                        <div class="upload__img-wrap">
                                            @foreach($media as $image)
                                                <div class="upload__img-box" >
                                                    <div style="background-image: url({{asset('images/media/').'/'.$image->image}});" data-number="4" data-file="Rectangle 7 (7).png" class="img-bg">
                                                        <div class="upload__img-close existing" data-id="{{$image->id}}">

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach


                                            <label class="upload__btn">
                                                <p class="m-0">Upload images</p>
                                                <input type="file" multiple="" data-max_length="20" name="image[]" class="upload__inputfile">
                                            </label>
                                        </div>

                                    </div>
                                </div>


                            </div>



                            <div class="d-none">
                                <input class="d-none" type="file" id="mediaimg">
                                <label for="mediaimg">
                                    <svg width="66" height="16" viewBox="0 0 66 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6 4L6.7396 2.8906C7.11053 2.3342 7.73499 2 8.4037 2H11.5963C12.265 2 12.8895 2.3342 13.2604 2.8906L14 4H19V15H1V4H6Z" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 12C11.6569 12 13 10.6569 13 9C13 7.34315 11.6569 6 10 6C8.34315 6 7 7.34315 7 9C7 10.6569 8.34315 12 10 12Z" stroke="black" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M63 8C63 8.55228 63.4477 9 64 9C64.5523 9 65 8.55228 65 8C65 7.44772 64.5523 7 64 7C63.4477 7 63 7.44772 63 8Z" stroke="black" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M63 2C63 2.55228 63.4477 3 64 3C64.5523 3 65 2.55228 65 2C65 1.44772 64.5523 1 64 1C63.4477 1 63 1.44772 63 2Z" stroke="black" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M63 14C63 14.5523 63.4477 15 64 15C64.5523 15 65 14.5523 65 14C65 13.4477 64.5523 13 64 13C63.4477 13 63 13.4477 63 14Z" stroke="black" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12" id="imageGallery"></div>
                        </div>
                        <div class="sit">
                            <div>
                                <input class="mt-3" type="text" value="{{$property->view36}}" name="view36" placeholder="360 url link">
                                <input class="mt-3" type="text" value="{{$property->video}}" name="video" placeholder="Video tour link">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{--                    <button class="btn tab-next-btn nextlocation">Next</button>--}}
                        </div>
                    </div>
                        <h2>Property Address & Hierarchy</h2>
                        <div class="row sit mb-3">
                            <div class="col-md-4">
                                <label class="font-weight-bold small">Master Community</label>
                                <input type="text" name="community" value="{{ old('community', $property->community) }}" placeholder="e.g. Palm Jumeirah, Emirates Hills">
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold small">Sub-Community / Cluster</label>
                                <input type="text" name="sub_community" value="{{ old('sub_community', $property->sub_community) }}" placeholder="e.g. Frond N, European Cluster">
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold small">Building / Villa Name</label>
                                <input type="text" name="building" value="{{ old('building', $property->building) }}" placeholder="e.g. Signature Villa, Tower 1">
                            </div>
                        </div>

                        <div class="d-md-flex sit">
                            <div class="col-md-6 py-3">
                                <input type="text" placeholder="Property Location Geocoding" id="pac-input"
                                        class="controls"
                                        value="{{$property->completesearch}}">
                                <p>To ensure high quality search score, enter the complete location and verify Google Maps pin coordinates.</p>
                            </div>
                            <div class="col-md-6 py-3">

                                {{--                        <img src="{{asset('management/images/Rectangle 45 (2).png')}}" alt="">--}}
                                <!--<input
                                        id="pac-input"
                                        class="controls"
                                        type="text"
                                        placeholder="Search Box"
                                        value="{{$property->completesearch}}"
                                />-->
                                <div id="map"></div>
                                <input type="hidden" id="address" name="address" value="{{$property->address}}"/>
                                <input type="hidden" id="locality" name="locality" value="{{$property->locality}}"/>
                                <input type="hidden" id="state" name="state" value="{{$property->state}}"/>
                                <input type="hidden" id="postcode" name="postcode" value="{{$property->postcode}}"/>
                                <input type="hidden" id="lat" name="lat" value="{{$property->lat}}"/>
                                <input type="hidden" id="lng" name="lng" value="{{$property->lng}}"/>
                                <input type="hidden" id="country" name="country" value="{{$property->country}}" />
                                <input type="hidden" id="maplink" name="map" value="{{$property->map}}" />
                                <input type="hidden" id="completesearch" name="completesearch"value="{{$property->completesearch}}" />
                            </div>
                        </div>
                        <div class="card">
                            <div class="body">
                                <h2>Floor Plan/Brochure</h2>
                                <div class="py-4">
{{--                                    <p>Drag & Drop File Here</p>--}}
                                    <input id="draganddrop" class="" name="brochure"  type="file">
{{--                                    <label for="draganddrop">Upload</label>--}}
{{--                                    <div id="preview"></div>--}}
                                    @if($property->brochure != null)
                                    <a target="_blank" href="{{asset('images/media'.'/'.$property->brochure)}}">View</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{--                <div class="card">--}}
                        {{--                    <div class="body">--}}
                        {{--                        <h2>Elite Evolution floor plans</h2>--}}
                        {{--                        <div class="py-4">--}}
                        {{--                            <input class="tab-input" type="text" placeholder="No Floor Plans are available for this location, Please enter a different one">--}}
                        {{--                        </div>--}}
                        {{--                    </div>--}}
                        {{--                </div>--}}
                        <div class="d-flex justify-content-center">
                            {{--                    <button class="btn tab-next-btn nextpublishing">Next</button>--}}
                        </div>
                    </div>
                    <div class="tab-pane fade py-3" id="publishing" role="tabpanel" aria-labelledby="publishing-tab">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="card p-3 publishcard">
                                    <img src="{{asset('management/images/image 5.png')}}" alt="">
                                    <hr class="customhr">
                                    <div>
                                        <p>Creation date</p>
                                        <div class="smallline"></div>
                                    </div>
                                    <div>
                                        <p>Generation date</p>
                                        <div class="smallline"></div>
                                    </div>
                                    <div>
                                        <p>Fetching date</p>
                                        <div class="smallline"></div>
                                    </div>
                                    <div class="justify-content-end">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
                                            <path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" />
                                        </svg>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn tab-next-btn">Submit</button>

                        </div>
                    </div>
                </div>
            </form>
            <div class="card d-none">
                <div class="body">
                    <h2>Elite Evolution floor plans</h2>
                    <div class="sit">
                        <div class="mt-5">
                            <input type="text" placeholder="No Floor Plans are available for this location, Please enter a different one">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Task Info -->
        <!-- Browser Usage -->
        <div class="d-none col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="header">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAlWLuEzszKgldMmuo9JjtKLxe9MGk75_k&callback=initAutocomplete&libraries=places&v=weekly"
            defer
    ></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });


        const fileInput = document.getElementById('draganddrop');
        const preview = document.getElementById('preview');
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const image = new Image();
                    image.src = reader.result;
                    preview.innerHTML = '';
                    preview.appendChild(image);
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });
        const SelectAmenitiesfileInput = document.getElementById('SelectAmenities');
        const SelectAmenitiespreview = document.getElementById('previewSelectAmenities');
        SelectAmenitiesfileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    const image = new Image();
                    image.src = reader.result;
                    SelectAmenitiespreview.innerHTML = '';
                    SelectAmenitiespreview.appendChild(image);
                };
                reader.readAsDataURL(file);
            } else {
                SelectAmenitiespreview.innerHTML = '';
            }
        });
        //media images

        var imageInput = document.getElementById('mediaimg');
        var imageGallery = document.getElementById('imageGallery');

        imageInput.addEventListener('change', function() {
            for (var i = 0; i < imageInput.files.length; i++) {
                var file = imageInput.files[i];
                var img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.classList.add('gallery-image');
                imageGallery.appendChild(img);
            }
        });
        //btn
        $(".nextpublishing").click(function() {
            $("#publishing-btn").click()
        })
        $(".nextmedia").click(function() {
            $("#media-btn").click()
        })
        $(".nextlocation").click(function() {
            $("#location-btn").click()
        })


        let autocomplete;


        function initAutocomplete() {


            // old code end
            // new code
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: {{isset($property->lat) ? $property->lat : 24.8558625}}, lng: {{isset($property->lng) ? $property->lng : 55.1581406}} },
                zoom: 13

            });
            const card = document.getElementById("pac-card");
            const input = document.getElementById("pac-input");
            const biasInputElement = document.getElementById("use-location-bias");
            const strictBoundsInputElement = document.getElementById("use-strict-bounds");
            const options = {

                componentRestrictions: { country: ["uk", "ae"] },
                fields: ["address_components", "geometry", "icon", "name","url"],
            };
            // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            //input.value = "V545+87R, Dubai, Dubai";
            autocomplete = new google.maps.places.Autocomplete(input, options);
            input.value = "{{$property->completesearch !=  null ? $property->completesearch : $property->address}}";
            console.log(autocomplete);
            // Bind the map's bounds (viewport) property to the autocomplete object,
            // so that the autocomplete requests use the current map bounds for the
            // bounds option in the request.
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });
            autocomplete.addListener("place_changed", () => {
                // autocomplete.bindTo('bounds', map);
                // placesmap(input,map);
                // fillInAddress(input,map);
                //
                let address1Field = document.getElementById("address1");
                let address2Field = document.getElementById("address");
                let postalField = document.getElementById("postcode");
                const place = autocomplete.getPlace();
                console.log(input.value);

                 $('#completesearch').val(input.value);

                /*map.addListener("bounds_changed", () => {
                    autocomplete.setBounds(map.getBounds());
                  });*/
                let address1 = "";
                let postcode = "";
                // const input = document.getElementById("pac-input");
                // const searchBox = new google.maps.places.SearchBox(input);
                // const places = autocomplete.getPlace();
                var latitude = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                document.getElementById("lat").value = latitude;
                document.getElementById("lng").value = longitude;
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setIcon(({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }


                // Get each component of the address from the place details,
                // and then fill-in the corresponding field on the form.
                // place.address_components are google.maps.GeocoderAddressComponent objects
                // which are documented at http://goo.gle/3l5i5Mr
                for (const component of place.address_components) {

                    // @ts-ignore remove once typings fixed
                    const componentType = component.types[0];

                    switch (componentType) {
                        case "street_number": {
                            address1 = `${component.long_name} ${address1}`;
                            break;
                        }

                        case "route": {
                            address1 += component.short_name;
                            break;
                        }

                        case "postal_code_prefix": {
                            postcode = `${component.long_name}${postcode}`;
                            break;
                        }
                        case "postal_code": {
                            postcode = `${component.long_name}${postcode}`;
                            break;
                        }

                        case "postal_code_suffix": {
                            postcode = `${postcode}-${component.long_name}`;
                            break;
                        }
                        case "locality":
                            document.querySelector("#locality").value = component.long_name;
                            break;
                        case "administrative_area_level_1": {
                            document.querySelector("#state").value = component.short_name;
                            break;
                        }
                        case "country":
                            document.querySelector("#country").value = component.long_name;
                            break;
                    }

                }

                document.querySelector("#maplink").value = place.url;

                address2Field.value = address1;
                postalField.value = postcode;
                // After filling the form with address components from the Autocomplete
                // prediction, set cursor focus on the second address line to encourage
                // entry of subpremise information such as apartment, unit, or floor number.
                address2Field.focus();

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setIcon(({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(', ');
                }

                address2Field.value = address;


            });


            // new code end

        }
        window.initAutocomplete = initAutocomplete;












        // jQuery(function() {
        //     jQuery('.multiSelect').each(function(e) {
        //         var self = jQuery(this);
        //         var field = self.find('.multiSelect_field');
        //         var fieldOption = field.find('option');
        //         var placeholder = field.attr('data-placeholder');
        //
        //         field.hide().after(`<div class="multiSelect_dropdown"></div>
        //                 <span class="multiSelect_placeholder">` + placeholder + `</span>
        //                 <ul class="multiSelect_list"></ul>
        //                 <span class="multiSelect_arrow"></span>`);
        //
        //         fieldOption.each(function(e) {
        //             jQuery('.multiSelect_list').append(`<li class="multiSelect_option" data-value="`+jQuery(this).val()+`">
        //                                     <a class="multiSelect_text">`+jQuery(this).text()+`</a>
        //                                   </li>`);
        //         });
        //
        //         var dropdown = self.find('.multiSelect_dropdown');
        //         var list = self.find('.multiSelect_list');
        //         var option = self.find('.multiSelect_option');
        //         var optionText = self.find('.multiSelect_text');
        //
        //         dropdown.attr('data-multiple', 'true');
        //         list.css('top', dropdown.height() + 5);
        //
        //         option.click(function(e) {
        //             var self = jQuery(this);
        //             e.stopPropagation();
        //             self.addClass('-selected');
        //             field.find('option:contains(' + self.children().text() + ')').prop('selected', true);
        //             dropdown.append(function(e) {
        //                 return jQuery('<span class="multiSelect_choice">'+ self.children().text() +'<svg class="multiSelect_deselect -iconX"><use href="#iconX"></use></svg></span>').click(function(e) {
        //                     var self = jQuery(this);
        //                     e.stopPropagation();
        //                     self.remove();
        //                     list.find('.multiSelect_option:contains(' + self.text() + ')').removeClass('-selected');
        //                     list.css('top', dropdown.height() + 5).find('.multiSelect_noselections').remove();
        //                     field.find('option:contains(' + self.text() + ')').prop('selected', false);
        //                     if (dropdown.children(':visible').length === 0) {
        //                         dropdown.removeClass('-hasValue');
        //                     }
        //                 });
        //             }).addClass('-hasValue');
        //             list.css('top', dropdown.height() + 5);
        //             if (!option.not('.-selected').length) {
        //                 list.append('<h5 class="multiSelect_noselections">No Selections</h5>');
        //             }
        //         });
        //
        //         dropdown.click(function(e) {
        //             e.stopPropagation();
        //             e.preventDefault();
        //             dropdown.toggleClass('-open');
        //             list.toggleClass('-open').scrollTop(0).css('top', dropdown.height() + 5);
        //         });
        //
        //         jQuery(document).on('click touch', function(e) {
        //             if (dropdown.hasClass('-open')) {
        //                 dropdown.toggleClass('-open');
        //                 list.removeClass('-open');
        //             }
        //         });
        //     });
        // });








        jQuery(document).ready(function () {
            ImgUpload();
        });

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            $('.upload__inputfile').each(function () {
                $(this).on('change', function (e) {
                    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                    var maxLength = $(this).attr('data-max_length');

                    var files = e.target.files;
                    var filesArr = Array.prototype.slice.call(files);
                    var iterator = 0;
                    filesArr.forEach(function (f, index) {

                        if (!f.type.match('image.*')) {
                            return;
                        }

                        if (imgArray.length > maxLength) {
                            return false
                        } else {
                            var len = 0;
                            for (var i = 0; i < imgArray.length; i++) {
                                if (imgArray[i] !== undefined) {
                                    len++;
                                }
                            }
                            if (len > maxLength) {
                                return false;
                            } else {
                                imgArray.push(f);

                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                    imgWrap.prepend(html);
                                    iterator++;
                                }
                                reader.readAsDataURL(f);
                            }
                        }
                    });
                });
            });

            $('body').on('click', ".upload__img-close", function (e) {
                var file = $(this).parent().data("file");
                for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i].name === file) {
                        imgArray.splice(i, 1);
                        break;
                    }
                }
                $(this).parent().parent().remove();
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.upload__img-close.existing', function () {
                var imagid = $(this).data('id');

                var actionperformer = $(this);
                $.ajax({
                    type: 'POST',
                    url: "{{url('admin/image-delete')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: imagid,
                    },
                    dataType: "json",
                    // beforeSend: function () {
                    //     $(".ajaxpreload").show();
                    // },
                    success: function (data) {
                        // if(data){
                        //     $(actionperformer).parents('.oldimage').remove()
                        // }

                    }
                });



            });
        });

    </script>

@endsection
