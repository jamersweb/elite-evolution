@extends('management.layouts.master')
@section('title')
Property - {{config('app.dashboard')}}
@endsection
@section('content')
<style>


    .select-dropdown>div {
        margin-bottom: 15px;
    }

    .select-dropdown>div select {
        width: 100%;
        border-radius: 10px;
        background-color: transparent;
        padding: 10px;
        border-color: #BC9C5B;
        color: #858383;
    }

    .bedroom-range p {
        display: flex;
        justify-content: space-between;
        display: flex;
        color: #858383;
    }

    .bedroom-range {
        color: #858383;
    }

    .bedroom-range>div {
        display: flex;
        color: #858383;
    }

    .bedroom-range>div input {
        background: transparent;
        border: none;
        margin: 10px 0 !important;
    }
    .table-property tbody tr{
        background-color: #F5F5F5 !important;
    }
    .table-property tbody tr td{
      padding-block: 10px !important;
    }
</style>

<div class="row ">
    <div class="col-12 ">
        <div class="card">
            <div class="body propertyTask">
                <a href="{{route('property.index')}}">All <span></span></a>
                <a href="{{route('property.index')}}?type=sale">sale <span>{{$sale}}</span></a>
                <a href="{{route('property.index')}}?type=rent">rent <span>{{$rent}}</span></a>
                <a href="{{route('property.index')}}?status=0">pending <span>{{$pending}}</span></a>
            </div>
        </div>
    </div>

</div>
<form action="{{route('property.index')}}" method="get">
    <div class="row select-dropdown">

        <div class="col-md-3 col-sm-6">
            <select class="form-select" name="furnishing_type" aria-label="Default select example">
                <option selected value="" disabled>Furnishing Type</option>
                <option {{isset($_GET['furnishing_type']) && $_GET['furnishing_type'] == 'Furnished' ? 'selected' : ''}} value="Furnished">Furnished</option>
                <option {{isset($_GET['furnishing_type']) && $_GET['furnishing_type']  == 'unfurnished' ? 'selected' : ''}} value="unfurnished">unfurnished</option>
            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <select name="bedrooms" class="form-select" aria-label="Default select example">
                <option selected value="" disabled>No Of Bathroom*</option>
                <option {{isset($_GET['bedrooms']) && $_GET['bedrooms']  == 1 ? 'selected' : ''}} value="1">1</option>
                <option {{isset($_GET['bedrooms']) && $_GET['bedrooms']  == 2 ? 'selected' : ''}} value="2">2</option>
                <option {{isset($_GET['bedrooms']) && $_GET['bedrooms']  == 3 ? 'selected' : ''}} value="3">3</option>
                <option {{isset($_GET['bedrooms']) && $_GET['bedrooms']  == 4 ? 'selected' : ''}} value="4">4</option>
                <option {{isset($_GET['bedrooms']) && $_GET['bedrooms']  == 5 ? 'selected' : ''}} value="5">5</option>

            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <select class="form-select" name="property_type" aria-label="Default select example">
                <option selected value="" disabled>Property Type*</option>
                <option value="Apartment">Apartment</option>
                <option value="Bungalow">Bungalow</option>
                <option value="Compound">compound</option>
                <option value="Duplex">Duplex</option>
                <option value="Full Floor">Full Floor</option>
            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <select class="form-select" name="category" aria-label="Default select example">
                <option selected value="" disabled>Commercial / Residential</option>
                <option value="Apartment">Apartment</option>
                <option value="Bungalow">Bungalow</option>
                <option value="Compound">compound</option>
                <option value="Duplex">Duplex</option>
                <option value="Full Floor">Full Floor</option>
            </select>
        </div>
        <div class="col-md-3 col-sm-6">
            <input type="number" class="form-control"  placeholder="Min Price" name="min_price">
        </div>
        <div class="col-md-3 col-sm-6">
            <input type="number" class="form-control"  placeholder="Max Price" name="max_price">
        </div>
{{--        <div class="col-md-3 col-sm-6">--}}
{{--            <select class="form-select" name="category" aria-label="Default select example">--}}
{{--                <option selected value="" disabled>Commercial / Residential</option>--}}
{{--                <option value="Apartment">Apartment</option>--}}
{{--                <option value="Bungalow">Bungalow</option>--}}
{{--                <option value="Compound">compound</option>--}}
{{--                <option value="Duplex">Duplex</option>--}}
{{--                <option value="Full Floor">Full Floor</option>--}}
{{--            </select>--}}
{{--        </div>--}}



{{--        <div class="col-md-3 col-sm-6 bedroom-range">--}}
{{--            Price--}}
{{--            <div class="">--}}
{{--                <label for="minbedrooms"></label>--}}
{{--                <input type="range" min="1000"  max="5000000" id="minbedrooms" name="min_price">--}}
{{--                <label for="maxbedrooms"></label>--}}
{{--                <input type="range" min="1000" max="5000000" id="maxbedrooms" name="max_price">--}}
{{--            </div>--}}
{{--            <p>--}}
{{--                <span>Min</span>--}}
{{--                <span>max</span>--}}
{{--            </p>--}}
{{--        </div>--}}
        <div class="col-md-3 col-sm-6 bedroom-range">

            <button type="submit" class="btn btn-signature ">Search</button>
        </div>

    </div>
</form>
</div>
<div class="row">
    <div class="col-lg-12 margin-tb my-3">
        <div class="pull-left">
            <h2 class="headingwithcount">Property <span class="count">{{count($property)}}</span></h2>
        </div>
        <div class="pull-right">

        @can('property-create')
            <a class="btn-icon" href="{{ route('property.create') }}">+</a>
            @endcan
        </div>
    </div>
</div>
{{-- @if ($message = Session::get('success'))--}}
{{-- <div class="alert alert-success">--}}
{{-- <p>{{ $message }}</p>--}}
{{-- </div>--}}
{{-- @endif--}}

<div class="card">
    <div class="body table-responsive">
        <table class="table table-property" id="myTable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Table Location</th>
                    <th>Layout Size</th>
                    <th>Type Offering</th>
                    <th>Price Category</th>
                    <th>Updated Listed</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($property as $properties)
                <tr>
                    <td>{{$properties->username}}</td>

                    <td>
                        <a style="color:#BC9C5B;" href="{{route('property.edit',$properties->id)}}">

                        {{$properties->title}}
                        </a>
                        </td>
                    <td>
                        <h5>
                           <span style="color:#BC9C5B;">   {{$properties->bedrooms}}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="20" viewBox="0 0 34 20" fill="none">
                                <path d="M33.9984 12.2799C33.9984 12.0588 33.9971 11.8371 33.978 11.6171C33.8728 10.4024 33.3752 9.35903 32.475 8.5085C31.4649 7.55376 30.2406 7.10617 28.8318 7.10844C26.4373 7.11264 24.0424 7.10844 21.6479 7.11297C21.4879 7.11329 21.4371 7.07187 21.4431 6.91522C21.4551 6.59741 21.4488 6.27862 21.4464 5.96048C21.4381 4.76431 20.454 3.81669 19.2193 3.81572C17.7434 3.81475 16.2678 3.81475 14.7918 3.81572C13.5578 3.81669 12.5744 4.76593 12.5664 5.96243C12.5644 6.28056 12.557 6.59903 12.5701 6.91684C12.5764 7.07672 12.5213 7.11329 12.3632 7.11297C10.4867 7.10779 8.60975 7.10973 6.73283 7.10973H6.5427C6.53802 7.04274 6.53167 6.99549 6.53167 6.94823C6.53134 5.29767 6.52967 3.6471 6.53502 1.99654C6.53535 1.87129 6.56509 1.73633 6.61889 1.62209C6.80868 1.21883 7.15921 1.08614 7.59828 1.08646C13.8693 1.08937 20.1399 1.0884 26.4109 1.08873C26.4774 1.08873 26.5445 1.09002 26.611 1.09552C27.1159 1.13565 27.4721 1.50266 27.4808 1.99298C27.4845 2.20334 27.4818 2.41371 27.4818 2.62408C27.4822 3.55195 27.4828 4.47983 27.4822 5.40738C27.4818 5.64688 27.5657 5.84203 27.7922 5.95757C28.1792 6.15532 28.6042 5.88572 28.6052 5.43942C28.6079 4.31218 28.6066 3.18494 28.6062 2.05738C28.6059 0.855705 27.7211 0.000647281 26.476 0C20.1606 0 13.8455 0 7.53011 0.000647281C6.28808 0.000647281 5.40693 0.858294 5.40659 2.06418C5.40659 3.6607 5.40659 5.25721 5.40626 6.85373C5.40626 7.14533 5.43466 7.10811 5.13493 7.10941C3.60286 7.1162 2.31739 7.66186 1.28654 8.76192C0.12236 10.0047 -0.0884879 11.5106 0.0277959 13.1003C0.0515205 13.423 0.367291 13.6246 0.68774 13.5676C0.959069 13.5194 1.1335 13.3019 1.14051 13.0068C1.15254 12.5003 1.11445 11.9867 1.18863 11.4889C1.47767 9.54286 3.116 8.19457 5.14763 8.1936C7.38643 8.19231 9.62523 8.19328 11.864 8.19328C17.5332 8.19328 23.2027 8.19231 28.8719 8.1936C31.1317 8.19425 32.8743 9.88818 32.8723 12.0747C32.8716 12.8676 32.8723 13.6605 32.8723 14.4535V14.6635H0.830756C0.752899 14.6635 0.674709 14.6619 0.596852 14.6641C0.250339 14.6732 0.0261252 14.8878 0.0147641 15.225C0.00975189 15.3651 0.0134275 15.5053 0.0134275 15.6457C0.0134275 16.8863 0.01443 18.1268 0.0127592 19.3676C0.0124251 19.6058 0.0876086 19.8039 0.310152 19.9262C0.696428 20.1385 1.13817 19.8693 1.13951 19.4168C1.14252 18.2572 1.14385 17.0976 1.13684 15.9377C1.13617 15.7843 1.18596 15.7509 1.33499 15.7513C11.7825 15.7542 22.23 15.7542 32.6775 15.7513C32.8262 15.7513 32.877 15.7836 32.876 15.9377C32.869 17.0649 32.872 18.1921 32.8726 19.3194C32.8726 19.3896 32.8716 19.4605 32.882 19.5294C32.9345 19.8735 33.3017 20.0838 33.6325 19.9618C33.8821 19.8699 33.9994 19.676 33.9994 19.3511C33.9994 16.994 34.0001 14.637 33.9984 12.2799ZM20.3086 7.0984H13.6922V6.56181C13.6922 6.35694 13.6891 6.15176 13.6928 5.94689C13.7032 5.37599 14.1837 4.90606 14.7731 4.90445C16.2601 4.90056 17.7471 4.90121 19.2337 4.90412C19.7663 4.90509 20.2475 5.28343 20.2996 5.79705C20.3431 6.22296 20.3086 6.65663 20.3086 7.0984Z" fill="black"/>
                            </svg>
                        </h5>
                        <h5>
                              <span style="color:#BC9C5B;">
                                  {{$properties->bathrooms}}
                              </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="27" viewBox="0 0 33 27" fill="none">
                                <path d="M1.00984 14.4873C1.08022 14.5178 1.10241 14.5522 1.10241 14.6297C1.10011 16.3665 1.07793 18.1041 1.10853 19.8408C1.13913 21.5722 1.81236 23.0304 3.04025 24.2196C3.39906 24.5677 3.79994 24.858 4.23142 25.1036C4.2582 25.1185 4.28344 25.1341 4.31864 25.1553C4.29186 25.1842 4.27044 25.2092 4.24749 25.2327C3.98814 25.4979 3.72649 25.7608 3.47021 26.0291C3.31108 26.195 3.26365 26.3968 3.34015 26.6167C3.41589 26.8365 3.57655 26.9617 3.803 26.9883C3.97054 27.0078 4.11972 26.9546 4.23907 26.8341C4.604 26.4649 4.96586 26.0933 5.32849 25.7209C5.35833 25.6904 5.38051 25.6528 5.40346 25.6231C5.65363 25.6779 5.89921 25.7483 6.14861 25.7835C6.4661 25.8281 6.78665 25.8695 7.10568 25.8695C13.3691 25.875 19.6324 25.8734 25.8958 25.8734C26.4589 25.8734 27.0097 25.785 27.5498 25.6262C27.5789 25.6176 27.608 25.6106 27.6202 25.6247C27.7296 25.7514 27.8337 25.8836 27.9492 26.0049C28.2162 26.2842 28.487 26.5595 28.7594 26.8334C28.9529 27.0282 29.239 27.054 29.4578 26.903C29.6698 26.7559 29.7593 26.4758 29.6591 26.2325C29.6262 26.152 29.5711 26.0753 29.5106 26.0111C29.2612 25.749 29.0065 25.4932 28.754 25.2343C28.7303 25.2108 28.7089 25.1858 28.6813 25.1553C28.7724 25.1013 28.8573 25.0528 28.9399 25.0004C30.5396 23.9864 31.5127 22.5368 31.8234 20.6349C31.8746 20.3228 31.8937 20.0012 31.8953 19.6836C31.9022 17.9969 31.8991 16.3094 31.8968 14.6219C31.8968 14.5483 31.9182 14.5155 31.9855 14.4865C32.7223 14.1681 33.1239 13.3881 32.9648 12.5925C32.808 11.8109 32.1309 11.2516 31.3383 11.2516C30.0584 11.2516 28.7785 11.2516 27.4978 11.2531C27.4282 11.2531 27.3945 11.2351 27.3632 11.1647C27.0633 10.4966 26.5553 10.1328 25.8323 10.1289C24.378 10.1211 22.9236 10.1266 21.4693 10.1266C20.7823 10.1266 20.1978 10.5224 19.9316 11.171C19.9063 11.2328 19.8765 11.2531 19.8115 11.2524C14.3399 11.2508 8.86756 11.2516 3.39523 11.2516H3.30037V1.74383C3.30037 1.3597 3.52911 1.12813 3.90781 1.12813C4.97121 1.12813 6.03462 1.12813 7.09803 1.12813C7.46983 1.12813 7.69935 1.36127 7.70011 1.7407C7.70088 1.92455 7.70011 2.1084 7.70011 2.29773C7.62973 2.31416 7.56546 2.32902 7.50044 2.34467C6.00096 2.70454 4.95056 4.06111 4.94979 5.63752C4.94979 5.81824 4.94903 5.99974 4.95056 6.18124C4.95209 6.50826 5.18849 6.75157 5.50674 6.75157C7.33672 6.75157 9.16669 6.75157 10.9967 6.75157C11.3103 6.75157 11.5498 6.50748 11.549 6.18672C11.549 5.76895 11.5773 5.34806 11.4794 4.93655C11.1558 3.57841 10.3303 2.71862 9.01369 2.3478C8.94636 2.32902 8.87751 2.3165 8.80024 2.29851C8.80024 2.09432 8.79947 1.89248 8.80024 1.68985C8.80024 1.40899 8.74133 1.14222 8.60668 0.898908C8.28843 0.323891 7.80569 0.0117386 7.15846 0.00547995C6.05222 -0.00390809 4.94673 0.0023506 3.84049 0.00313294C2.93927 0.00391528 2.201 0.759652 2.201 1.68203C2.20024 4.82546 2.20024 7.9681 2.20024 11.1115V11.2516C2.00898 11.2516 1.82614 11.2516 1.64406 11.2516C1.27072 11.2531 0.934864 11.3705 0.640323 11.6044C-0.358054 12.3977 -0.155318 13.9843 1.00984 14.4873ZM9.62954 3.88039C10.1658 4.32867 10.4313 4.91308 10.4504 5.62422H6.0591C6.03462 4.96628 6.38654 4.11431 7.18983 3.65821C7.96635 3.21697 8.93489 3.2999 9.62954 3.88039ZM26.3992 16.8703H20.9039C20.9024 16.8382 20.8993 16.8109 20.8993 16.7835C20.8993 15.1398 20.8986 13.4969 20.8993 11.8532C20.9001 11.4871 21.1327 11.2516 21.493 11.2516C22.929 11.2516 24.365 11.2516 25.801 11.2516C26.1712 11.2516 26.3992 11.4863 26.3992 11.8673V16.8703ZM26.3962 18.007V19.1172H20.9055V18.007H26.3962ZM31.3108 13.5008C30.0714 13.5016 28.8313 13.5008 27.5912 13.5008C27.5621 13.5008 27.533 13.4977 27.5016 13.4961V12.3758H30.991C31.1134 12.3758 31.2358 12.3727 31.3574 12.3774C31.6099 12.386 31.8256 12.5651 31.8823 12.8092C31.9664 13.1761 31.7009 13.5 31.3108 13.5008ZM2.201 14.7103C2.201 14.6837 2.20483 14.6571 2.20636 14.632H19.7992V19.6327C19.7992 20.0231 20.0203 20.2492 20.4021 20.2492H26.9003C27.2752 20.2492 27.4986 20.0208 27.4986 19.6374V14.6305H30.799V19.664C30.799 20.0716 30.7546 20.4745 30.6605 20.8704C30.115 23.1634 28.132 24.7477 25.801 24.7484C19.5988 24.75 13.3958 24.75 7.19366 24.7461C6.90524 24.7461 6.61299 24.7211 6.32763 24.6733C3.99273 24.2869 2.22472 22.1902 2.20483 19.7712C2.19106 18.0845 2.201 16.397 2.201 14.7103ZM1.69761 12.3758H19.6982C19.7304 12.3758 19.7625 12.3789 19.7962 12.3805V13.5008H1.74275C1.70602 13.5008 1.6693 13.5016 1.63258 13.4992C1.41531 13.4859 1.25618 13.3772 1.15902 13.1808C0.968525 12.7982 1.25236 12.3758 1.69761 12.3758Z" fill="black"/>
                            </svg>
                        </h5>

                    <td>
                        <h5>
                              <span style="color:#BC9C5B;">
                                  {{$properties->property_type}}
                              </span>
                        </h5>
                        <h5>
                              <span class="text-capitalize text-muted" >
                                  {{$properties->type}}
                              </span>
                        </h5>
                    </td>
                    <td>
                        <h5>
                              <span style="color:#BC9C5B;">
                                 AED {{$properties->price}}
                              </span>
                        </h5>
                        <h5>
                              <span class="text-capitalize text-muted" >
                                    {{$properties->land_type}}
                              </span>
                        </h5>
                    </td>
                    <td>
                        <h5>
                              <span style="color:#BC9C5B;">
                                  {{$properties->updated_at}}
                              </span>
                        </h5>
                        <h5>
                              <span class="text-capitalize text-muted" >
                                    {{$properties->created_at}}
                              </span>
                        </h5>
                    </td>
                    <td>
                        @if($properties->status == 1)
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="21" viewBox="0 0 28 21" fill="none">
                                <path d="M1 10.8182L9.125 19L27 1" stroke="#BC9C5B" stroke-width="2" stroke-linecap="round"/>
                            </svg>

                        @else
                            <img src="{{asset('management/wrong.png')}}" alt="">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>


</div>


{{-- {!! $roles->render() !!}--}}
@endsection
