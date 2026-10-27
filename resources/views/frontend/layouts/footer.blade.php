<style>
    .whatsapp-btn {
        position: fixed;
        bottom: 40px;
        right: 40px;
        width: 60px;
    }
    .social-icons {
        display: flex;
        justify-content: start;
        align-items: center;
        margin-block: 15px

    }

    .social-icons a {
        text-decoration: none;
        color: #bb9c5b;
        margin: 0 15px;
        font-size: 24px;
        transition: color 0.3s ease-in-out;
    }

    .social-icons a:hover {
        color: #fff; /* Change to the color you prefer on hover */
    }

    .ee-enquiry { background: #fbf9f4; padding: 80px 0; }
    .ee-enquiry-card {
        background: #fff;
        border: 1px solid #ebe5d8;
        border-radius: 14px;
        padding: 48px;
        max-width: 960px;
        margin: 0 auto;
        box-shadow: 0 20px 50px rgba(0,0,0,.05);
    }
    .ee-enquiry-intro { text-align: center; margin-bottom: 28px; }
    .ee-enquiry-intro span { color: #bb9e5b; font-size: 13px; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; }
    .ee-enquiry-intro h2 { font-size: clamp(24px, 3vw, 34px); text-transform: uppercase; margin: 10px 0 12px; color: #111; }
    .ee-enquiry-intro p { color: #6f6f6f; max-width: 560px; margin: 0 auto; }
    @media (max-width: 575px) { .ee-enquiry-card { padding: 28px 18px; } }
</style>
@php
    $developers = \App\Models\Developer::whereStatus(1)->get();
@endphp


<section class="ee-enquiry">
<div class="container">
<div class="ee-enquiry-card">
<div class="ee-enquiry-intro">
    <span>Private Client Desk</span>
    <h2>Speak With a Licensed Advisor</h2>
    <p>Tell us what you are looking for and a RERA-registered broker will be in touch shortly.</p>
</div>
<script charset="utf-8" type="text/javascript" src="//js-eu1.hsforms.net/forms/embed/v2.js"></script>
<script>
  hbspt.forms.create({
    region: "eu1",
    portalId: "143377444",
    formId: "26e25df9-4a21-47c2-a6a4-3733b470b06d",
    onFormSubmit: function($form) {
      // Redirect to the thank-you page after a successful form submission
      window.location.href = "https://eliteevolutionrealestate.ae/thank-you";
    }
  });
</script>
</div>
</div>
</section>
<footer class="banner-footer">
    <div class="container py-4 px-md-5">
        <div class="row m-0 align-items-top">
            <div class="col-lg-3 col-md-3 col-sm-12 py-3">
                <img class="elit-img" src="{{asset('management/images/elite-evolution-real-estate-in-white.png')}}" onerror="this.onerror=null;this.src='{{asset('management/images/logo.png')}}';" alt="Elite Evolution Real Estate">
                <div class="social-icons">
                    <a href="https://www.facebook.com/EliteEvolutionRealEstate" target="_blank" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/eliteevolutionrealestate/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/eliteevolutionrealestate/" target="_blank" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 py-3">
                <h6 class="text-white fw-bold">QUICK LINKS</h6>
                <ul class="m-0 p-0">
                    <li><a href="{{url('listing/ready')}}" class="link">Ready Properties</a></li>
                    <li><a href="{{url('listing/off-plan')}}" class="link">Off Plan Projects</a></li>
                    <li><a href="{{url('luxury-rentals')}}" class="link">Luxury Rentals</a></li>
                    <li><a href="{{url('agents')}}" class="link">Licensed Brokers</a></li>
                    <li><a href="{{url('contact-us')}}" class="link">Contact Us</a></li>
                    <li><a href="{{url('career')}}" class="link">Careers</a></li>
                    {{-- Market Insights hidden until current content is ready --}}
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 py-3">
                <h6 class="text-white fw-bold">OFF PLAN DEVELOPERS</h6>
                <ul class="m-0 p-0">
                    @foreach($developers as $developer)
                        <li>
                            <a class="link" href="{{url('/developer',$developer->slug)}}">{{$developer->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 py-3">
                <h6 class="text-white fw-bold">COMPANY & LEGAL</h6>
                <ul class="m-0 p-0">
                    <li><a href="{{url('terms-and-conditions')}}" class="link">Terms & Conditions</a></li>
                    <li><a href="{{url('privacy-policy')}}" class="link">Privacy Policy</a></li>
                    <li><a href="{{url('cookies-policy')}}" class="link">Cookies Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
    @include('frontend.layouts.concierge_widget')
</footer>
@include('frontend.layouts.site_intro')
<script>
    $(function() {
        // Owl Carousel
        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 10,
            dots: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false
                }
            }
        });
    });
</script>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="{{asset('frontend/app.js')}}"></script>
<script src="{{asset('frontend/js/script.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.readmore').on('click', function() {
            $(this).parents('.contentbox').find('.more').slideToggle(500);
            var buttonText = $(this).text();
            if (buttonText === "Read More") {
                $(this).text("Read Less");
            } else {
                $(this).text("Read More");
            }
        })



        $('body').on('click', '.close', function() {
            $(this).parents('.alert').remove();
        });

        $(document).on('click', '.suggestionbar .list', function() {
            $('.search-location').val($(this).text());
            $('.suggestionbar').empty();
        })


        $(document).on('keyup', '.search-location', function() {
            var value = $(this).val();

            var actionperformer = $(this).siblings('div').find('ul');
            if (value.trim().length >= 3) {

                $.ajax({
                    type: 'GET',
                    url: "{{url('/location-search')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        input: value,
                    },
                    dataType: "json",

                    // beforeSend: function () {
                    //     $(".ajaxpreload").show();
                    // },
                    success: function(data) {
                        $(actionperformer).empty();
                        if (data.length != 0) {
                            $.each(data, function(key, value) {
                                $(actionperformer).append('<li class="list">' + value + '</li>');
                            });
                        } else {
                            $(actionperformer).append('<li>We can not find your search query. Please check your spelling or try a different location.</li>');
                        }

                        // if(data){
                        //     $(actionperformer).parents('.oldimage').remove()
                        // }

                    }
                });
            } else {
                $(actionperformer).empty();
            }


        });
    });
    $('.price-btn').on('click', function() {
        $('.price-sec').toggle(300)
    })




    $(document).ready(function () {
        @if(session('success'))
        toastr.success('{{ session('success') }}');
        @endif
    });
</script>

<!-- Start of HubSpot Embed Code -->
<script type="text/javascript" id="hs-script-loader" async defer src="//js-eu1.hs-scripts.com/143377444.js"></script>
<!-- End of HubSpot Embed Code -->


</body>

</html>
