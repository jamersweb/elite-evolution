@extends('layouts.app')
<style>


</style>
@section('content')
        <div class="container-fluid">

            <div class="row justify-content-center align-items-center bg-login">
                <div class="col-md-6 dd p-0">
                    <div class="row m-0 text">
                        <div class="col-lg-12 px-md-5">
                            <img width="230px" class="elite-logo" src="{{asset('management/images/elite-logo.png')}}" alt="">
                        </div>
                    </div>
                    <div class="px-md-5 py-md-4">

                        <div class="text-color">

                            <div class="text-center pt-md-3 pt-5 fs27 font-weight">
                                {{ __('Login To Your Account') }}
                            </div>
{{--                            <div>--}}
{{--                                <p class="text-white text-center m-0 pt-md-2">Your Own Digital Campaign </p>--}}
{{--                            </div>--}}
{{--                            <div class="text-center">--}}
{{--                                <span class="sp-color">---</span><span class="px-md-2 sp-color">OR</span><span class="sp-color">---</span>--}}
{{--                            </div>--}}
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="row mb-3">
                                    {{--                            <label for="email" class="col-md-12 ">{{ __('Email Address') }}</label>--}}

                                    <div class="col-md-12">
                                        <input id="email" placeholder="Username" type="email"
                                               class=" inp-field @error('email') is-invalid @enderror" name="email"
                                               value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    {{--                            <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}</label>--}}

                                    <div class="col-md-12">
                                        <input id="password" type="password" placeholder="Password"
                                               class=" inp-field @error('password') is-invalid @enderror" name="password"
                                               required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input text-white" type="checkbox" name="remember"
                                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label sp-color" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-check p-0 text-end">
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link text-signature sp-color"
                                                   href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn bg-signature text-light">
                                            {{ __('Login') }}
                                        </button>
                                        <div class="text-center pt-md-3 pt-3">
                                            <p class="m-0"><span class="sp-color">Not A Member Yet?</span><a href="#" class="text-white px-md-2 px-2">Register Now</a></p>
                                        </div>

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



    <!-- <div class="container">

    <h2>hello container</h2>

    </div> -->

@endsection

