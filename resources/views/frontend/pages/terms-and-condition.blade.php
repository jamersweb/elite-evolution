@extends('frontend.layouts.master')

@section('title')
Terms and Conditions | Elite Evolution
@endsection

@section('meta_title')
Terms and Conditions | Elite Evolution
@endsection

@section('meta_description')
Explore the terms and conditions of Elite Evolution Real Estate. Understand the guidelines and agreements for using our platform and services.
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
    {{--    <section class="container-fluid hero-banner" style="background: url({{asset('frontend/img/blog.png')}});">--}}
    {{--        <div class="row align-items-center h-100">--}}
    {{--            <div class="col-12">--}}
    {{--                <h1 class="text-center text-uppercase text-white">Appraise Your Property with Elite Evolution</h1>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}
    <section>
        <div class="container px-md-5 py-md-5">
            <div class="row py-md-5">
                <div class="col-lg-9 mx-auto">



                    <h1 class="mb-4">Terms and Conditions</h1>
                    <h4>
                        ACCEPTANCE OF THE TERMS OF USE
                    </h4>
                    <p>
                        THESE ARE GENERAL TERMS AND CONDITIONS OF ELITE EVOLUTION REAL ESTATE L.L.C. (“COMPANY”) GOVERNING YOUR ACCESS AND USE OF THE “WEBSITE”. IF YOU DO NOT AGREE WITH THESE TERMS AND CONDITIONS, PLEASE DO NOT USE THE WEBSITE. BY CONTINUING TO USE THE WEBSITE, CONTENTS, AND/OR ANY OF THE SERVICES SHOWN ON THE SITE, YOU AGREE TO BE BOUND BY THESE TERMS AND CONDITIONS.        </p>
                    <h4>CHANGES TO THE TERMS OF USE</h4>
                    <p>
                        We may revise and update these Terms of Use from time to time at our sole discretion. All changes are effective immediately when we post them and apply to all access to and use of the Website thereafter. Your continued use of the Website following the posting of the revised Terms of Use means that you accept and agree to the changes. You are expected to check this page from time to time so you are aware of any changes, as they are binding on you.
                    </p>
                    <h4>ACCESSING THE WEBSITE AND ACCOUNT SECURITY</h4>
                    <p>
                        We reserve the right to withdraw or amend the Website, and any service or material
                        we provide on the Website, in our sole discretion without notice. We will not be
                        liable if for any reason all or any part of the Website is unavailable at any time
                        or for any period. From time to time, we may restrict access to some parts of the
                        Website, or the entire website, to any user, including registered users.
                    </p>
                    <p>
                        To access the Website or some of the resources it offers including, without limitation,
                        payment using credit cards or other forms of electronic payment, you may be asked to provide
                        certain registration details or other information. It is a condition of your use of the
                        Website that all the information, including, without limitation, credit card information or
                        information pertaining to other forms of electronic payments, you provide on the Website is
                        correct, current, and complete. You agree that all information you provide to register with this
                        Website or otherwise, including but not limited to through the use of any interactive features
                        on the Website, is governed by our Privacy Policy, and you consent
                        to all actions we take with respect to your information consistent with our Privacy Policy.
                    </p>
                    <p>
                        If you choose or are provided with a username, password, or any other piece of information
                        as part of our security procedures, you must treat such information as confidential,
                        and you must not disclose it to any other person or entity. You also acknowledge that your account
                        is personal to you and agree not to provide any other person with access to this Website
                        or portions of it using your username, password, or other security information.
                        You agree to notify us immediately of any unauthorized access to or use of your username
                        or password or any other breach of security. You also agree to ensure that you exit from
                        your account at the end of each session. You should use particular caution when accessing
                        your account from a public or shared computer so that others are not able to view or record
                        your password or other personal information.
                    </p>
                    <h4>COPYRIGHT</h4>
                    <p>
                        Copyright in the pages and in the screens displaying the pages, and in the
                        information and material therein and in their arrangement, is owned by
                        ELITE EVOLUTION REAL ESTATE L.L.C. unless otherwise
                        indicated. Reuse of any content is strictly prohibited unless otherwise stated.
                    </p>
                    <h4>TRADEMARKS</h4>
                    <p>
                        ELITE EVOLUTION REAL ESTATE L.L.C., its subsidiaries, affiliates, contractors, and/or participating corporations are the owners of the trade and service marks appearing on this website and all rights are reserved in respect of such trade and service marks.
                    </p>

                    <h4>WARRANTY</h4>
                    <p>
                        The company does not warrant the accuracy, correctness, completeness,
                        and acceptance of the contents and/or any other information and/or materials available on the website.
                        No warranties of any kind whether express, implied, or by-laws, including but not limited to the
                        warranties of non-infringement of third-party rights,
                        security, fitness, quality, compatibility, accuracy, and safety.
                    </p>

                    <h4>LIMITATION OF LIABILITY</h4>
                    <p>
                        Under no circumstance, ELITE EVOLUTION REAL ESTATE L.L.C. be liable for any feature,
                        function (programming errors, other errors, linking, rectification of the errors, updating, omissions),
                        and safety (including loss/ damage of any personal data/information, or any loss whether foreseen,
                        foreseeable, known or otherwise) mechanism built in the website. ELITE EVOLUTION REAL ESTATE L.L.C.
                        or any of its affiliates is not liable for any consequential, incidental damages whether direct or
                        indirect arising out of the use of the website. Contents of the website have not been investigated,
                        verified, and/or not continuously monitored. The company reserves all rights to disclose information
                        as it deems necessary to satisfy any applicable law or refuse to disclose, edit,
                        or remove any content information, or materials, in whole or in part, at the company´s sole discretion.
                    </p>
                    <h4>SUBMISSION</h4>
                    <p>
                        All information submitted to ELITE EVOLUTION REAL ESTATE L.L.C.
                        via this site shall be deemed and remain the property of ELITE EVOLUTION REAL ESTATE L.L.C.
                        who shall be free to use, for any purpose, any ideas, concepts, know-how, or techniques contained
                        in information a visitor to this site provides ELITE EVOLUTION REAL ESTATE L.L.C. through this site.
                        ELITE EVOLUTION REAL ESTATE L.L.C. shall not be subject to any obligations of confidentiality or privacy
                        regarding submitted information except as agreed by the ELITE EVOLUTION REAL ESTATE L.L.C.
                        or as otherwise specifically agreed or required by law.
                    </p>
                    <h4>VARIATIONS</h4>
                    <p>
                        These Terms and Conditions are subject to change at any time without notice and even after any such change will not change the obligation of the user.
                    </p>

                    <h4>GOVERNING LAWS AND JURISDICTION</h4>
                    <p>
                        Your use of the company website, its content, services, and/or any information/material posted or
                        available on the website shall be governed by the law of the United Arab Emirates.
                    </p>
                    <h4>DISCLAIMER:</h4>
                    <p>
                        No representation or warranty of any kind whatsoever express or implied for the accuracy,
                        correctness, completeness, fitness to the purpose, or non-infringement of any content or
                        any other information or material posted or available on the website. Any tangible or intangible
                        harm/damage or any consequential or incidental damages thereof of any kind to the user,
                        by accessing the website and/or any breach of the undertaking, is at User´s own risk.
                        </p>





                </div>

            </div>
        </div>
    </section>
@endsection
