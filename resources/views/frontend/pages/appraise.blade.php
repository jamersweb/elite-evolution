@extends('frontend.layouts.master')
@section('title')
    Appraise
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
    </style>
    <section class="container-fluid hero-banner" style="background: url({{asset('frontend/img/blog.png')}});">
        <div class="row align-items-center h-100">
            <div class="col-12">
                <h1 class="text-center text-uppercase text-white">Appraise Your Property with Elite Evolution</h1>
            </div>
        </div>
    </section>



    <section>
        <div class="container py-5">
            <div class="row">
                <div class="main_details col-12 col-md-10 mx-auto">
                    <div class="contentbox">
                        <h2> Introducing Elite Evolution: Your Path to Selling Property in Dubai</h2>
                        <p> If you're seeking to sell a property in Dubai and collaborate with knowledgeable and professional agents, your search ends here! Choose Elite Evolution, your trusted partner in property sales.
                        <h2>Why Elite Evolution?</h2>
                        <h5> Unmatched Agent Expertise:</h5>
                        <p>
                            At Elite Evolution, we boast a team of dedicated agents who specialize in specific areas. With their wealth of experience in selling properties in your locality, they will be your trusted guides throughout the entire process.
                        </p>
                        <h5> Extensive Buyer Network:</h5>
                        <p>
                            We consistently register hundreds of new buyers each week. By leveraging our vast network, we maintain a waitlist of potential buyers eagerly seeking new properties. Rest assured, your property will receive maximum exposure to qualified leads.
                        </p>
                        <div class="more" style="display: none">






                            <h5>Cutting-Edge Marketing Strategies:</h5>
                            <p>To showcase your property to its fullest potential, we employ comprehensive marketing techniques. Our professional marketing team will capture your property's best features through stunning photography and engaging video tours. We also optimize property descriptions to highlight its unique selling points. By implementing search engine optimization (SEO) and pay-per-click (PPC) campaigns, we ensure prominent visibility across major property portals. Moreover, we harness the power of social channels to reach audiences of potential buyers.
                            </p>
                            <h5>Personalized Client Focus:</h5>
                            <p>
                                We believe in personalized attention and understanding your specific circumstances. Our brokers will provide tailored information at every stage of the sale process. By collaborating closely with you, we ensure a seamless experience and effective communication.
                            </p>
                            <h5>
                                Unparalleled Market Insights:
                            </h5>
                            <p>
                                Our brokers are at the forefront of market trends. They will offer invaluable advice to help you price your property competitively and attract serious buyers. With our in-depth knowledge of your property type and area, we effectively communicate its unique value to potential buyers.
                            </p>
                            <h5>Broad Media Exposure:</h5>
                            <p>
                                To find your perfect buyer, we employ a multi-channel marketing approach. When you choose Elite Evolution, your property will receive maximum exposure across various media platforms. From our award-winning website to prominent property portals such as houza Property Finder, Dubizzle, and Bayut, we leave no stone unturned. Our comprehensive marketing package includes full-color property details, immersive 3D tours, professional pictures, and email and SMS alerts.
                            </p>
                            <h5>
                                Streamlined Sales Progression:
                            </h5>
                            <p> Once the contracts are signed, our dedicated in-house sales progression team takes charge. They navigate you through the entire legal process with utmost efficiency. From coordinating with developers and banks to securing necessary certificates, they ensure a seamless transaction, minimizing delays.
                            </p>
                            </p>
                        </div>
                        <button class="readmore bg-transparent border-0 p-0">Read More</button>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section>
        <div class="container px-md-5 py-md-5">
            <div class="row py-md-5">
                <div class="col-lg-8 mx-auto">
                    @include('management/layouts/error')
                    <form id="your-form-id" action="{{ url('appraise-your-property') }}" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <h2 class="text-uppercase text-center">Book a property valuation</h2>
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
                                <input type="text" class="form-control" name="address" placeholder="Property Address" aria-label="Phone number" required>
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



    <section>
        <div class="container py-5">
            <div class="row">
                <div class="main_details col-12 col-md-10 mx-auto">
                    <div class="price">
                        <h2 class="col-12 text-center">Guide to sell your property in Dubai</h2>
                        <p class="text-center">
                            We understand that selling a property can be overwhelming, especially for first-time sellers. That's why we have developed a step-by-step guide to simplify the process and put your mind at ease.
                        </p>
                        <div class="accordion pt-4" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_1"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_1" aria-expanded="true" aria-controls="collapse_1">Step 1: Partner with a Reliable Broker:  </button></h2>
                                <div id="collapse_1" class="accordion-collapse collapse show" aria-labelledby="heading_1" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        Finding a trustworthy agent who understands your needs and builds a strong relationship with you is crucial. At Elite Evolution, we prioritize open and honest communication. Our agents provide expert advice on the Dubai property market and share market appraisals, enabling you to make informed decisions.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_2" aria-expanded="false" aria-controls="collapse_2">Step 2: Conduct Due Diligence:</button></h2>
                                <div id="collapse_2" class="accordion-collapse collapse" aria-labelledby="heading_2" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Before setting a price for your property, conduct thorough research. Explore property portals to compare prices of recently sold properties in your area. Consider similar properties in other neighborhoods to gauge market trends and ensure your asking price is realistic.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_3"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_3" aria-expanded="false" aria-controls="collapse_3">Step 3: Opt for Exclusivity</button></h2>
                                <div id="collapse_3" class="accordion-collapse collapse" aria-labelledby="heading_3" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>Choosing to work exclusively with Elite Evolution ensures consistent marketing messaging. This minimizes confusion and guarantees that your property is represented accurately with a unified strategy.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_5"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_5" aria-expanded="false" aria-controls="collapse_5">Step 4: Enhance Your Property's Appeal</button></h2>
                                <div id="collapse_5" class="accordion-collapse collapse" aria-labelledby="heading_4" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Prepare your property for marketing by decluttering and presenting it in the best possible light. Our professional photographers will capture its essence, and we can create immersive 3D tours and captivating property videos. We will leverage our extensive communication channels to reach potential buyers effectively.  </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_6"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_6" aria-expanded="false" aria-controls="collapse_6">Step 5: Impress Potential Buyers during Viewings</button></h2>
                                <div id="collapse_6" class="accordion-collapse collapse" aria-labelledby="heading_6" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Ensure your property is in top condition before scheduled viewings. Share key highlights with your broker, allowing them to emphasize unique features that may sway buyers. By conveying your love for the property, we create an emotional connection and increase its desirability.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_8"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_8" aria-expanded="false" aria-controls="collapse_8">Step 6: Skilled Negotiation and Contract Signing</button></h2>
                                <div id="collapse_8" class="accordion-collapse collapse" aria-labelledby="heading_8" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Rely on your Elite Evolution broker's expertise during the negotiation process. With access to valuable feedback, market data, and comparable sales, they will guide you to make informed decisions. Once a verbal agreement is reached, we will facilitate the contract signing process.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_9"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_9" aria-expanded="false" aria-controls="collapse_9">Step 7: Smooth Sales Progression</button></h2>
                                <div id="collapse_9" class="accordion-collapse collapse" aria-labelledby="heading_9" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        Our in-house sales progression team will support you throughout the entire process, ensuring a seamless experience. From obtaining the No Objections Certificate (NOC) to coordinating with all involved parties, we handle the paperwork and logistics to minimize any potential delays.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
