@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-items-center bg-login">

        <div class="col-md-6 dd p-0">
            <div class="row m-0">
            <div class="col-lg-12 px-md-5">
                <img width="230px" class="elite-logo" src="{{asset('management/images/elite-logo.png')}}" alt="">
            </div>
            </div>
            <div class="px-md-5 py-md-4">
                <div class="text-color">

                    <div class="text-center pt-md-3 pt-5 fs27 font-weight">
                        {{ __('Forgot Password?') }}
                    </div>
                    <div>
                        <p class="text-white text-center m-0 pt-md-2">No Worries, we’ll send you reset instructions</p>
                    </div>

                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
{{--                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>--}}

                            <div class="col-md-12">
                                <input id="email" placeholder="{{ __('Enter Your Email') }}" type="email" class="inp-field @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn bg-signature text-white">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                        <p class="text-center pt-md-3"><a href="#" class="sp-color"><i class="fas fa-long-arrow"></i>Back To Login</a></p>
                    </form>
                        <div class="set  pt-md-3">
                            <p class="sp-color m-0">Privacy Policy</p>
                            <p class="sp-color m-0">Copyright 2023</p>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 p-0 login-banner">
            <img class="img" src="{{asset('management/images/forget-img.png')}}" alt="">
        </div>
    </div>
</div>

@endsection
