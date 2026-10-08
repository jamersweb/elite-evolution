@extends('frontend.layouts.master')

@section('title')
Contact Elite Evolution | Reach Out for Real Estate Investments
@endsection

@section('meta_title')
Contact Elite Evolution | Reach Out for Real Estate Investments
@endsection

@section('meta_description')
Have questions or need assistance? Contact Elite Evolution for expert real estate investments. Reach out to us today for personalized assistance.
@endsection

@section('content')
    <style>
        .blogs img {
            height: 200px;
            object-fit: cover;
        }
        .hero-banner{
            height:60vh;
            background-position: center;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            position: relative;
        }
        .hero-banner:before {
            content: "";
            background: rgba(0,0,0,.4);
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
        }
        .hero-banner  div{
            z-index: 99;
        }
        ul.icon-list-items {
            padding: 0;
        }
        li.icon-list-item a, li.icon-list-item span {
            color: black;
            font-size: 18px;

        }
        li.icon-list-item{
            margin-block: 10px;
        }

        li.icon-list-item i {
            color: #bb9e5b;
            margin-right: 4px;

        }
    </style>
    <section class="container-fluid hero-banner" style="background: url({{asset('frontend/img/contact.png')}});">
        <div class="row align-items-center h-100">
            <div class="col-12">
                <h1 class="text-center text-uppercase text-white">Get in Touch Today</h1>
            </div>
        </div>
    </section>
    <section>
        <div class="container px-md-5 py-md-5">
            <div class="row py-md-5">

                <div class="col-md-6">
                    <h2>Get an <span style="color:#bb9e5b;">instant reply!</span>
                    </h2>
                    <p class="pb-3">Contact us with any questions or inquiries. We would be happy to get in touch and set up a meeting with you. Look forward to hearing from you!</p>
                    <ul class="icon-list-items">
                        <li class="icon-list-item">
                            <a href="mailto:info@eliteevolutionrealestate.ae">

												<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="fas fa-envelope"></i>						</span>
                                <span class="elementor-icon-list-text">info@eliteevolutionrealestate.ae</span>
                            </a>
                        </li>
                        <li class="icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="fas fa-map-marker-alt"></i>						</span>
                            <span class="elementor-icon-list-text">Saeed Haseeb Building Port Saeed, Deira, PO Box 233025 Dubai, UAE</span>
                        </li>
                        <li class="icon-list-item">
                            <a href="tel:+971569700771">

												<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="fas fa-phone-alt"></i>						</span>
                                <span class="elementor-icon-list-text">+971 56 970 0771</span>
{{--                                <span class="elementor-icon-list-text">+971 58 659 2743</span>--}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    @include('management/layouts/error')
                    <form id="your-form-id" action="{{ url('contact-us') }}" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <h3 class="text-uppercase text-center">WE WOULD LOVE TO HEAR FROM YOU,
                                    PLEASE BE IN TOUCH!</h3>
                            </div>
                            <div class="col-md-12">
                                @csrf
                                <input type="text" class="form-control" name="name" placeholder="Full Name" aria-label="First name" required>
                            </div>
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" required>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="phone" placeholder="Phone number" aria-label="Phone number" required>
                            </div>
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" aria-label="Phone number" required>
                            </div>
                            <div class="col-md-12">
                                <textarea class="form-control" name="message" placeholder="Message" aria-label="Message" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block w-100 btn-dark rounded-pill text-uppercase " onclick="submitForm()"> Submit Detail</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
