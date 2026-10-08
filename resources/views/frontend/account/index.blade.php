@extends('frontend.layouts.master')
@section('title')
    Residential - Admin Control Panel
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
            @include('frontend/account/sidebar')
            </div>
            <div class="col-md-9">
                <div class="card px-md-5 py-5 border-0">
                    <div class="card-body">
                        <form action="{{url('update-password')}}" method="post" enctype="multipart/form-data">
@csrf
                                <div class="profile-image-outer-container">

                                    <h4 class="text-purp text-uppercase"> Change password</h4>

                                </div>

                            @include('management.layouts.error')


                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <input type="password" placeholder="Enter current password" class="py-3 form-control text-dark rounded-pill " name="password" required="" autocomplete="email">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <input id="text" placeholder="Enter new password" type="password" class="py-3 text-dark rounded-pill form-control " name="new_password" required="" autocomplete="current-password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <input type="password" placeholder="Confirm new password" class="py-3 form-control text-dark rounded-pill" val="" name="confirm_password" value="" autocomplete="email" min="0">
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="bg-dark text-white btn read-more-cta px-4 py-2 fs-5 text-uppercase my-4">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
