@extends('frontend.layouts.master')
@section('title')
    sales - Admin Control Panel
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row m-0">
                <div class="col-lg-4">
                    <div class="">
                        <h1 class="pt-md-5 pt-3 fw-bold">HOUSING SUMMER</h1>
                        <p style="color: #707070;" class="font-weihgt"><i class="fa-solid fa-location-dot px-md-1 px-2 text-color"></i>Asayel, Madinat Jumeirah Living, Umm Suqeim, Dubai</p>
                    </div>
                </div>
                <div class="col-lg-5"></div>
                <div class="col-lg-3">
                    <div class="">
                        <h1 class="pt-md-5 pt-3 fw-bold">1,790,000 AED</h1>
                        <p style="color: #707070;" class="text-end font-weihgt">Estimated Mortgage<br> 8,363 AED/month</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="banner-agents">
        <h1 class="text-center py-md-5 fw-bold">MEET THE AGENTS</h1>

        <div class="container">
            <div class="mySlides">
                <div class="numbertext">1 / 6</div>
                <img src="./img/Rect.png" style="width:100%;">
            </div>

            <div class="mySlides">
                <div class="numbertext">2 / 6</div>
                <img src="./img/Rect.png" style="width:100%;">
            </div>

            <div class="mySlides">
                <div class="numbertext">3 / 6</div>
                <img src="./img/Rect.png" style="width:100%;">
            </div>

            <div class="mySlides">
                <div class="numbertext">4 / 6</div>
                <img src="./img/Rect.png" style="width:100%;">
            </div>

            <div class="mySlides">
                <div class="numbertext">5 / 6</div>
                <img src="./img/Rect.png" style="width:100%;">
            </div>

            <div class="mySlides">
                <div class="numbertext">6 / 6</div>
                <img src="./img/Rect.png" style="width:100%;">
            </div>
            <div class="row">
                <div class="column">
                    <img class="demo cursor" src="./img/Rectangle 16.png" style="width:100%; margin-top:10px;"
                         onclick="currentSlide(1)" alt="The Woods">
                </div>
                <div class="column">
                    <img class="demo cursor" src="./img/Rectangle 16.png" style="width:100%; margin-top:10px;"
                         onclick="currentSlide(2)" alt="Cinque Terre">
                </div>
                <div class="column">
                    <img class="demo cursor" src="./img/Rectangle 16.png" style="width:100%;margin-top:10px;"
                         onclick="currentSlide(3)" alt="Mountains and fjords">
                </div>
                <div class="column">
                    <img class="demo cursor" src="./img/Rectangle 16.png" style="width:100%;margin-top:10px;"
                         onclick="currentSlide(4)" alt="Northern Lights">
                </div>
                <div class="column">
                    <img class="demo cursor" src="./img/Rectangle 16.png" style="width:100%;margin-top:10px;"
                         onclick="currentSlide(5)" alt="Nature and sunrise">
                </div>
                <div class="column">
                    <img class="demo cursor" src="./img/Rectangle 16.png" style="width:100%; margin-top:10px;"
                         onclick="currentSlide(6)" alt="Snowy Mountains">
                </div>
            </div>
        </div>


        <section>
            <div class="container">
                <div class="row m-0 py-md-5">
                    <div class="col-lg-8">
                        <div class="banner-white p-md-5 p-4">
                            <div class="">

                                <h5 class="mt-md-3">1-Bedroom | Asayel 3 | Handover Soon</h5>
                                <div class="row pt-md-3">
                                    <div class="col-lg-3 col-sm-12 col-md-6 text-center">
                                        <div class="shadow p-4 mb-md-0 mb-2">
                                            <p class="text-color fw-bold">Property Type</p>
                                            <img src="./img/Vector (5).png" class="bedroom" alt="">
                                            <p class="">Apartment</p>
                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-md-6 text-center">
                                        <div class="shadow p-4 mb-md-0 mb-2">
                                            <p class="text-color fw-bold">01</p>
                                            <img src="./img/Vector (2).png" class="bedroom" alt="">
                                            <p>Bedroom</p>
                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-md-6 text-center">
                                        <div class="shadow p-4 mb-md-0 mb-2">
                                            <p class="text-color fw-bold">01</p>
                                            <img src="./img/Vector (3).png" class="bedroom" alt="">
                                            <p>Bathroom</p>
                                        </div>

                                    </div>
                                    <div class="col-lg-3 col-sm-12 col-md-6  text-center">
                                        <div class="shadow p-4 mb-md-0 mb-2">
                                            <p class="text-color fw-bold">774</p>
                                            <img src="./img/Vector (4).png" class="bedroom" alt="">
                                            <p>SQFT</p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="banner-white p-md-5 p-3 my-md-3">
                            <div class="">
                                <button class="button1"><i class="fa-solid fa-trophy px-md-1 "></i>SUPERAGENT</button>
                                <p class="fw-bold pt-md-5 pt-3">
                                    A SuperAgent provides the best possible information with the most</p>
                                <p class="fw-bold">up-to-date listings in the market, all while ensuring to respond to
                                </p>
                                <p class="fw-bold">home seekers faster than the rest.</p>
                            </div>
                            <a href="" class="text-color fw-bold">Learn More About This</a>

                        </div>
                        <div class="banner-white p-md-5 p-3 my-md-3">
                            <div class="">
                                <button class="button1">Amenities</button>
                                <div class="row">
                                    <div class="col-lg-3 py-md-3 py-3">
                                        <ul class="p-0">
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Partly
                                                Furnishedz</li>
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Built in
                                                Wardrobes</li>
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Covered Parking
                                            </li>
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Shared Gym</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 py-md-3">
                                        <ul class="p-0">
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Balcony</li>
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Central A/C
                                            </li>
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Concierge</li>
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Shared Pool
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 py-md-3">
                                        <ul class="p-0">
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Partly
                                                furnished</li>
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Children's Play
                                                Area</li>
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>Security</li>
                                            <li class="pt-md-3"><i class="fa-solid fa-check px-md-1 px-2"></i>View of
                                                Landmark</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="banner-white p-md-5 p-3 my-md-3">
                            <div class="">
                                <button class="button1">Description</button>
                                <p class=" pt-md-5 pt-3">
                                    luxe homes is pleased to offer you this 1-Bedroom Apartment on Madinat Jumeirah
                                    Living,<br> Asayel 3. Accessible via Sheikh Zayed Road and through public
                                    transportation. The closest<br> Bus Stop is Burj Al Arab Hotel 2 Bus Stop within a
                                    5-minute walk away and the nearest<br> Metro Station is Mall of the Emirates Metro
                                    Station an 8-minute drive away.</p>
                            </div>
                            <a href="" class="text-color fw-bold">Learn More About This</a>

                        </div>
                        <div class="banner-white p-md-5 p-3 my-md-3 my-md-0 my-3">
                            <div class="">
                                <button class="button1">Location</button>
                                <br>
                                <br>
                                <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d465130.67125385697!2d54.228961692504924!3d24.38709942049137!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e440f723ef2b9%3A0xc7cc2e9341971108!2sAbu%20Dhabi%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2s!4v1682936528235!5m2!1sen!2s"
                                        width="100%" height="300" style="border:0;" class="map" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>


                        </div>
                        <div class="banner-white p-md-5 p-3 my-md-3">
                            <div class="">
                                <button class="button1">Prices & Trends</button>
                                <img style="width: 100%;height: 330px;" src="./img/graf.png" alt="">

                            </div>


                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="banner-white p-md-5 p-3 my-md-3">
                                    <div class="">
                                        <img src="./img/Vect.png" alt="">
                                        <p class="mt-md-3 fw-bold fs-15">This property costs 6% less than the
                                        </p>
                                        <p class="fw-bold fs-15">average size of 1 bedroom in Umm Suqeim</p>
                                        <p class="fw-bold fs-15">Average Sale Price is 1,900,000 AED</p>

                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="banner-white p-md-5 p-3 my-md-3">
                                    <div class="">
                                        <img src="./img/Vect.png" alt="">
                                        <p class="mt-md-3 fw-bold fs-15">This property is the same size as the</p>
                                        <p class="fw-bold fs-15">average size of 1 bedroom in Umm Suqeim</p>
                                        <p class="fw-bold fs-15">Average size is 774 sqft</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="py-md-0 py-5">The data displayed is based on average prices and sizes of all listings that were<br> live on
                            elite Evolution in Umm Suqeim
                        </p>

                    </div>
                    <div class="col-lg-4">
                        <div class="banner-white px-md-5 py-md-3 px-3">
                            <div class="row row-cols-1 row-cols-md-1 g-4">
                                <div class="col">
                                    <p class="fw-bold">AGENT</p>
                                    <div class="text-center">
                                        <img src="./img/img1.png" class="" alt="...">
                                        <div class="card-body text-center">
                                            <h5 class="card-title fw-bold fs-18 text-centere">NABIJON RAHMATOV</h5>
                                            <p class="card-text text-center">Sales and Leasing Consultant at <br>luxe
                                                homes Real Estate
                                            </p>
                                            <div class="text-center">
                                                <img src="./img/image 7.png" alt="">
                                                <p class="text-center fw-bold fs-14 m-0 py-md-3 py-3">SALES AND LEASING
                                                    CONSULTANT AT <br>HOMES REAL Estate</p>
                                                <div class="text-center mb-md-3 mb-2">
                                                    <button class="Proprties">185 Proprties</button>
                                                </div>
                                                <div class="d-flex justify-content-center mb-md-0 mb-3">
                                                    <button class="button1"><i
                                                                class="fa-solid fa-phone px-md-1"></i>Call</button>
                                                    <button class="button1"><i
                                                                class="fa-solid fa-envelope px-md-1"></i>Email</button>
                                                    <button class="button1"><i
                                                                class="fa-brands fa-whatsapp px-md-1"></i>Whatsapp</button>

                                                </div>
                                                <div class="tect-center pt-md-3">
                                                    <button class="btn btn-dark w-100 text-color font-weihgt"
                                                            type="submit">SUPERAGENT</button>
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
        </section>
        <section class="banner-white">
            <h1 class="text-center py-md-5 py-3 fw-bold">MORE AVAILABLE IN THE SAME AREA</h1>
            <div class="container pb-md-5">
                <div class="row">
                    <div class="col-lg-3 col-sm-12 col-md-6 py-md-0 py-3">
                        <div class="card">
                            <img src="./img/card.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="fw-bold text-color">Apartments</p>
                                <h6 class="card-title">1,790,000 AED</h6>
                                <p class="card-text">Asayel, Madinat Jumeirah Living, Umm Suqeim, Dubai</p>
                                <div class="d-flex">
                                    <img src="./img/Vector (2).png" class="vector" alt="">
                                    <img src="./img/Vector (3).png" class="vector" alt="">
                                    <img src="./img/Vector (4).png" class="vector" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-6 py-md-0 py-3">
                        <div class="card">
                            <img src="./img/card1.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="fw-bold text-color">Apartments</p>
                                <h6 class="card-title">1,790,000 AED</h6>
                                <p class="card-text">Asayel, Madinat Jumeirah Living, Umm Suqeim, Dubai</p>
                                <div class="d-flex">
                                    <img src="./img/Vector (2).png" class="vector" alt="">
                                    <img src="./img/Vector (3).png" class="vector" alt="">
                                    <img src="./img/Vector (4).png" class="vector" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-6 py-md-0 py-3">
                        <div class="card">
                            <img src="./img/card2.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="fw-bold text-color">Apartments</p>
                                <h6 class="card-title">1,790,000 AED</h6>
                                <p class="card-text">Asayel, Madinat Jumeirah Living, Umm Suqeim, Dubai</p>
                                <div class="d-flex">
                                    <img src="./img/Vector (2).png" class="vector" alt="">
                                    <img src="./img/Vector (3).png" class="vector" alt="">
                                    <img src="./img/Vector (4).png" class="vector" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 col-md-6 py-md-0 py-3">
                        <div class="card">
                            <img src="./img/card3.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="fw-bold text-color">Apartments</p>
                                <h6 class="card-title">1,790,000 AED</h6>
                                <p class="card-text">Asayel, Madinat Jumeirah Living, Umm Suqeim, Dubai</p>
                                <div class="d-flex">
                                    <img src="./img/Vector (2).png" class="vector" alt="">
                                    <img src="./img/Vector (3).png" class="vector" alt="">
                                    <img src="./img/Vector (4).png" class="vector" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <section style="background-color:#161616;" class="py-md-5 py-4">
        <div class="container">
            <div class="text-center">
                <h1 class="text-color">DON’T MISS OUT!</h1>
                <h2 class="text-color">Get notified with new properties for<br>Asayel</h2>
                <form action="">
                    <input type="email" name="" id="" placeholder="Email" class="input">
                    <br>
                    <button class="btn-notify fw-bold">Notify Me</button>
                </form>
            </div>
        </div>
    </section>
@endsection