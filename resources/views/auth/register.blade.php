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
            <div class="px-md-5 py-md-5">
                <div class="text-color">

                    <div class="text-center pt-md-3 pt-5 fs27 font-weight">
                        {{ __('Login To Your Account') }}
                    </div>
{{--                    <div>--}}
{{--                        <p class="text-white text-center m-0 pt-md-2">Your Own Digital Campaign </p>--}}
{{--                    </div>--}}
{{--                    <div class="text-center">--}}
{{--                        <span class="sp-color">---</span><span class="px-md-2 sp-color">OR</span><span class="sp-color">---</span>--}}
{{--                    </div>--}}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
{{--                            <label for="name" class="col-md-12 col-form-label text-md-end">{{ __('Name') }}</label>--}}

                            <div class="col-md-6 mb-3">
                                <input id="name" type="text" placeholder="First Name" class=" inp-field @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="Last Name" class=" inp-field @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
{{--                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>--}}

                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="{{ __('Email Address') }}" class=" inp-field @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
{{--                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>--}}

                            <div class="col-md-12">
                                <input id="password" placeholder="Password" type="password" class=" inp-field @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
{{--                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>--}}

                            <div class="col-md-12">
                                <input placeholder="{{ __('Confirm Password') }}" id="password-confirm" type="password" class=" inp-field" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input text-white" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label sp-color" for="remember">
                                        {{ __('Yes, I understand & agree to the Stanley Terms of services') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn bg-signature text-white">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <div class="text-center pt-md-3 pt-3">
                            <p class="m-0"><span class="sp-color">Already have an account?</span><a href="#" class="text-white px-md-2 px-2">Login In</a></p>
                            </div>
                        </div>
                    </form>
                    <div class="set  pt-md-3">
                        <p class="sp-color m-0">Privacy Policy</p>
                        <p class="sp-color m-0">Copyright 2023</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 p-0 login-banner">
            <img class="img" src="{{asset('management/images/login-banner.png')}}" alt="">
        </div>
    </div>
</div>
@endsection
