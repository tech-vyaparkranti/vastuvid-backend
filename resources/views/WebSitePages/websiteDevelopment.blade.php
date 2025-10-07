@extends('layout.app_layout')
@section('title', 'Web Development')
@section('bodyClass', 'landingpage')
@section('content')
{{-- Header section  --}}
<div class="navigation-bar">
    <div class="main-container">
        <div class="brand-logo">
            <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo_3d.png') }}" srcset="{{ asset('assets/img/logo_3d.png') }}, {{ asset('assets/img/logo_3d.png') }} 767w" alt="Vyapar Kranti" title="Vyapar kranti" /></a>
        </div>
        <div class="side-navigation">
            <ul>
                <li><a href="#aboutus">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#review">Review</a></li>
                <li><a href="#footer-section">Contact Us</a></li>
                <li><a href="tel:+919958224825"><i class="fa fa-phone"></i>&nbsp;Call Now</a></li>
            </ul>
        </div>
    </div>
</div>
{{-- Header section  --}}
<section class="layout-slide">
    <div class="fixed-banner">
        <div class="main-container">
            <div class="row">
                <div class="fixed-content col-md-8 col-sm-12 col-12">
                    <h2>Website Design & Development</h2>
                    <p>Showcase your business to the world using the innovative WEB Solutions & boost up your business growth. Bridging the gap between seller and buyer to maximize the opportunity to serve.</p>
                    <div class="banner-btn"><a href="#footer-section" class="prime-btn">get started now</a></div>
                </div>
                <div class="landing-form col-md-4 col-sm-12 col-12">
                    <div class="site-title">
                        <h2 class="text-center">Enquiry Now</h2>
                    </div>
                    <form id="contactFormSubmit" action="javascript:">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Your Name" required data-error="Please enter your name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" placeholder="Your Email" id="emailId" class="form-control"
                                        name="emailId" required data-error="Please enter your email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="number" placeholder="Your contact number" id="contact_number" class="form-control"
                                        name="contact_number" required data-error="Please enter contact your number">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea onchange="refreshCapthca('captcha_img_id_contact_us','captcha_text_contactUs')" class="form-control" id="message" name="message" placeholder="Your Message" rows="3" data-error="Write your message"
                                        required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="row">
                                    <div class="col-md-12 form-group form-inline">
                                        <div class="col-8 p-0">
                                            <img src="{{ captcha_src() }}" class="img-thumbnail" name="captcha_img" alt="Vyapar Kranti"
                                                id="captcha_img_id_contact_us">
                                        </div>
                                        <div class="col-4">
                                            <button style="padding:.6em" type="button" 
                                                class="btn btn-common" onclick="refreshCapthca('captcha_img_id_contact_us','captcha_text_contactUs')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                                    <path fill-rule="evenodd"
                                                        d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter Text in image" class="form-control"
                                        name="captcha" id="captcha_text_contactUs" required />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="submit-button">
                                    <button class="btn btn-common submitbutton" id="submit" type="submit">SEND MESSAGE</button>
                                    <div id="msgSubmit" class="h3 hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</section>
<section id="aboutus" class="mb-5 mt-5">
    <div class="main-container">
        <div class="h_service-title pb-4">
            <h2>About <b>Vyapar Kranti</b></h2>
        </div>
        <p class="text-center">Welcome to Vyapar KRANTI, a leading Digital Marketing & IT company dedicated to helping entrepreneurs to transform their businesses into digital platforms. With our rich experience of more than 10 years in the Industry, we understand the importance of a strong online presence in today's digital age. Our team of experts specialize in Website development, Application development, Software development, Digital Marketing and Many more Verticals of Digital world. We strive to deliver innovative and effective solutions that drive growth and success for our clients. Let us help you take your business to the next level with our cutting-edge digital solutions.</p>
    </div>
</section>

<section class="h_service" id="services">
    <div class="main-container">
        <div class="h_service-title">
            <h2>Get your business online easily & be visible to your buyers</h2>
            <p>We provide solutions that will help you to give a voice to your ideas.</p>
        </div>
        <div class="h_service-container">
            <div class="h_service-inner">
                <div class="h_service-item">
                    <div class="h_serve_icon"><span class="material-symbols-outlined">colors</span></div>
                    <h4>Designs & Creatives</h4>
                    <p>Elevate Your Digital Presence with Seamless Design Excellence:</p>
                </div>
                <div class="h_service-item">
                    <div class="h_serve_icon"><span class="material-symbols-outlined">settings</span></div>
                    <h4>Web development</h4>
                    <p>Building Tomorrow's Web Today: Elevate Your Business with Our Web Solutions</p>
                </div>
                <div class="h_service-item">
                    <div class="h_serve_icon"><span class="material-symbols-outlined">campaign</span></div>
                    <h4>Digital Marketing</h4>
                    <p>From Clicks to Conversions Transform Your Business with Vyapar Kranti’s Expert Digital Marketing Services</p>
                </div>
                <div class="h_service-item">
                    <div class="h_serve_icon"><span class="material-symbols-outlined">checkbook</span></div>
                    <h4>Content writing</h4>
                    <p>Fuel your brand's story with <b>VYAPAR KRANTI’s</b> content writing mastery, driving engagement, and sparking networks that boom your BUSINESS.</p>
                </div>
                <div class="h_service-item">
                    <div class="h_serve_icon"><span class="material-symbols-outlined">monitoring</span></div>
                    <h4>Business Intelligence (BI) and Analytics</h4>
                    <p>Unlock actionable visions to take strategic decisions with our Business Intelligence (BI) and Analytics solutions – Turning data into a weapon to compete.</p>
                </div>
                <div class="h_service-item">
                    <div class="h_serve_icon"><span class="material-symbols-outlined">collections_bookmark</span></div>
                    <h4>Brand Solutions</h4>
                    <p>Elevate your brand presence and captivate audiences with our cutting-edge media solutions – where creativity meets engagement for unparalleled storytelling.</p>
                </div>
            </div>
            <div class="h_service-more text-center"><a class="prime-btn" data-toggle="modal" data-target="#vyaparkrantimodals" href="#">View More Services</a></div>
        </div>
    </div>
</section>
<!-- Section End -->
<section class="package-section">
        <div class="main-container top-align">
            <div class="h_service-title">
                <h2>Website Development Packages</h2>
                <p> Our Affordable Packages</p>
            </div>
            <div class="row mt-4 mb-4" id="mobile-package-slider">
                <div class="col-lg-3 col-sm-6 col-md-6 col-12 mb-2 mt-4">
                    <div class="package-container midd-section">
                        <div class="package-inner">
                            <h4 class="plance-title text-uppercase mt-2">Jump Starter</h4>
                            {{-- <p class="package-price m-0 text-left"><span class="price-ammount"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;6,999</span>&nbsp;/&nbsp;<span class="price-strike-ammount"><i class="fa fa-inr" aria-hidden="true"></i>9,999</span>&nbsp;<label class="m-0">(30% OFF)</label></p> --}}
                        </div>
                        <div class="package-list">
                            <h6 class="mt-0">What's Included:</h6>
                            <ul  class="list-none m-0">
                                <li><p>Web Pages - Up to 5</p></li>
                                <li><p>No. of Features - 10</p></li>
                            </ul>
                        </div>
                        <div class="select-packege-query  mt-3">
                            <button type="submit" class="btn btn-common" data-toggle="modal" data-target="#vyaparkrantimodals">Get Started</button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-sm-6 col-md-6 col-12 mb-2 mt-4">
                    <div class="package-container midd-section">
                        <div class="package-inner">
                            <h4 class="plance-title text-uppercase mt-2">Pro Plan</h4>
                            {{-- <p class="package-price m-0 text-left"><span class="price-ammount"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;9,999</span>&nbsp;/&nbsp;<span class="price-strike-ammount"><i class="fa fa-inr" aria-hidden="true"></i>14,999</span>&nbsp;<label class="m-0">(33% OFF)</label></p> --}}
                        </div>
                        <div class="package-list">
                            <h6 class="mt-0">What's Included:</h6>
                            <ul  class="list-none m-0">
                                <li><p>Web Pages - Up to 8</p></li>
                                <li><p>No. of Features - 15</p></li>
                            </ul>
                        </div>
                        <div class="select-packege-query  mt-3">
                            <button type="submit" class="btn btn-common" data-toggle="modal" data-target="#vyaparkrantimodals">Get Started</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-12 mb-2 mt-4">
                    <div class="package-container midd-section">
                        <div class="package-inner">
                            <h4 class="plance-title text-uppercase mt-2">Business Booster</h4>
                            {{-- <p class="package-price m-0 text-left"><span class="price-ammount"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;13,499</span>&nbsp;/&nbsp;<span class="price-strike-ammount"><i class="fa fa-inr" aria-hidden="true"></i>19,999</span>&nbsp;<label class="m-0">(33% OFF)</label></p> --}}
                        </div>
                        <div class="package-list">
                            <h6 class="mt-0">What's Included:</h6>
                            <ul  class="list-none m-0">
                                <li><p>Web Pages - Up to 12</p></li>
                                <li><p>No. of Features - 20</p></li>
                            </ul>
                        </div>
                        <div class="select-packege-query  mt-3">
                            <button type="submit" class="btn btn-common" data-toggle="modal" data-target="#vyaparkrantimodals">Get Started</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-12 mb-2 mt-4">
                    <div class="package-container midd-section">
                        <div class="package-inner">
                            <h4 class="plance-title text-uppercase mt-2">Brand Builder</h4>
                            {{-- <p class="package-price m-0 text-left"><span class="price-ammount"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;16,999</span>&nbsp;/&nbsp;<span class="price-strike-ammount"><i class="fa fa-inr" aria-hidden="true"></i>24,999</span>&nbsp;<label class="m-0">(32% OFF)</label></p> --}}
                        </div>
                        <div class="package-list">
                            <h6 class="mt-0">What's Included:</h6>
                            <ul  class="list-none m-0">
                                <li><p>Web Pages - Up to 15</p></li>
                                <li><p>No. of Features - 25</p></li>
                            </ul>
                        </div>
                        <div class="select-packege-query  mt-3">
                            <button type="submit" class="btn btn-common" data-toggle="modal" data-target="#vyaparkrantimodals">Get Started</button>
                        </div>
                    </div>
                </div>
            
                {{-- <div class="col-lg-3 col-sm-6 col-md-6 col-12 mb-2 mt-4">
                    <div class="package-container midd-section">
                        <div class="package-inner">
                            <h4 class="plance-title text-uppercase mt-2">Enterprise</h4>
                            <p class="package-price m-0 text-left"><span class="price-ammount"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;19,999</span>&nbsp;/&nbsp;<span class="price-strike-ammount"><i class="fa fa-inr" aria-hidden="true"></i>29,999</span>&nbsp;<label class="m-0">(33% OFF)</label></p>
                            <!-- <p class="mt-1">This package is suitable for tearms 1-15 people</p> -->
                        </div>
                        <div class="package-list">
                            <h6 class="mt-0">What's Included:</h6>
                            <ul  class="list-none m-0">
                                <li><p>Web Pages - Up to 20</p></li>
                                <li><p>No. of Features - 30</p></li>
                            </ul>
                        </div>
                        <div class="select-packege-query  mt-3">
                            <button type="submit" class="btn btn-common" data-toggle="modal" data-target="#vyaparkrantimodals">Get Started</button>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-12 col-sm-12 col-md-12 col-12 mb-2 mt-4"> <div class="h_service-title">
                    <h2>Digital Marketing Packages</h2>
                    <p>Our Affordable Packages</p>
                </div></div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-12 mb-2 mt-4">
                    <div class="package-container midd-section">
                        <div class="package-inner">
                            <h4 class="plance-title text-uppercase mt-2">Basic Plan</h4>
                            <p class="package-price m-0 text-left">
                            {{-- <span class="price-ammount"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;9,999</span> --}}
                        </div>
                        <div class="package-list">
                            <h6 class="mt-0">What's Included:</h6>
                            <ul  class="list-none m-0">
                                <li><p>SEO, SMM, Content Marketing, PPC</p></li>
                                <li><p>Ad budget upto 25,000</p></li>
                                <li><p>No. of Keywords - 10</p></li>
                                <li><p class="text-center"><b>Best for Startups</b></p></li>
                            </ul>
                        </div>
                        <div class="select-packege-query  mt-3">
                            <button type="submit" class="btn btn-common" data-toggle="modal" data-target="#vyaparkrantimodals">Get Started</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-12 mb-2 mt-4">
                    <div class="package-container midd-section">
                        <div class="package-inner">
                            <h4 class="plance-title text-uppercase mt-2">Standard Plan</h4>
                            <p class="package-price m-0 text-left">
                            {{-- <span class="price-ammount"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;14,999</span> --}}
                        </div>
                        <div class="package-list">
                            <h6 class="mt-0">What's Included:</h6>
                            <ul  class="list-none m-0">
                            <li><p>SEO, SMM, Content Marketing, PPC</p></li>
                                <li><p>Ad budget upto 50,000</p></li>
                                <li><p>No. of Keywords - 15</p></li>
                                <li><p class="text-center"><b>Best for Small Size Business</b></p></li>
                            </ul>
                        </div>
                        <div class="select-packege-query  mt-3">
                            <button type="submit" class="btn btn-common" data-toggle="modal" data-target="#vyaparkrantimodals">Get Started</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-12 mb-2 mt-4">
                    <div class="package-container midd-section">
                        <div class="package-inner">
                            <h4 class="plance-title text-uppercase mt-2">Pro Plan</h4>
                            <p class="package-price m-0 text-left">
                            {{-- <span class="price-ammount"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;24,999</span> --}}
                        </div>
                        <div class="package-list">
                            <h6 class="mt-0">What's Included:</h6>
                            <ul  class="list-none m-0">
                            <li><p>SEO, SMM, Content Marketing, PPC</p></li>
                                <li><p>Ad budget upto 1,00,000</p></li>
                                <li><p>No. of Keywords - 25</p></li>
                                <li><p class="text-center"><b>Best for Medium Size Business</b></p></li>
                            </ul>
                        </div>
                        <div class="select-packege-query  mt-3">
                            <button type="submit" class="btn btn-common" data-toggle="modal" data-target="#vyaparkrantimodals">Get Started</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-12 mb-2 mt-4">
                    <div class="package-container midd-section">
                        <div class="package-inner">
                            <h4 class="plance-title text-uppercase mt-2">Premium Plan</h4>
                            <p class="package-price m-0 text-left">
                            {{-- <span class="price-ammount"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;34,999</span> --}}
                        </div>
                        <div class="package-list">
                            <h6 class="mt-0">What's Included:</h6>
                            <ul  class="list-none m-0">
                            <li><p>SEO, SMM, Content Marketing, PPC</p></li>
                                <li><p>Ad budget upto 1,75,000</p></li>
                                <li><p>No. of Keywords - 35</p></li>
                                <li><p class="text-center"><b>Best for Enterprises Business</b></p></li>
                            </ul>
                        </div>
                        <div class="select-packege-query  mt-3">
                            <button type="submit" class="btn btn-common" data-toggle="modal" data-target="#vyaparkrantimodals">Get Started</button>
                        </div>
                    </div>
                </div>
            </div>
    
    </section>

    <section class="package-section">
        <div class="main-container top-align">
            <div class="h_service-title">
                <h2>Client Portfolio</h2>
            </div>
            <div class="row mt-4 mb-4" id="mobile-package-slider">
                <div class="col-lg-4 col-sm-6 col-md-4 col-12 mb-2 mt-4">
                    <div class="portfolio-figure">
                        <a data-fancybox="gallery" data-src="assets/img/project/krishidha.jpeg"><img src="assets/img/project/krishidha.jpeg" alt="krishidha"></a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-md-4 col-12 mb-2 mt-4">
                    <div class="portfolio-figure">
                        <a data-fancybox="gallery" data-src="assets/img/project/caterernevent.jpeg"><img src="assets/img/project/caterernevent.jpeg" alt="Caterer & Event"></a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-md-4 col-12 mb-2 mt-4">
                    <div class="portfolio-figure">
                        <a data-fancybox="gallery" data-src="assets/img/project/grsitc.jpeg"><img src="assets/img/project/grsitc.jpeg" alt="Grsitc"></a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-md-4 col-12 mb-2 mt-4">
                    <div class="portfolio-figure">
                        <a data-fancybox="gallery" data-src="assets/img/project/seclean.jpeg"><img src="assets/img/project/seclean.jpeg" alt="Seclean Services"></a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-md-4 col-12 mb-2 mt-4">
                    <div class="portfolio-figure">
                        <a data-fancybox="gallery" data-src="assets/img/project/sthirta.jpeg"><img src="assets/img/project/sthirta.jpeg" alt="Sthirta Corp"></a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-md-4 col-12 mb-2 mt-4">
                    <div class="portfolio-figure">
                        <a data-fancybox="gallery" data-src="assets/img/project/torna.jpeg"><img src="assets/img/project/torna.jpeg" alt="Torna"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
{{-- Testimonial Section  --}}
<section id="review" class="testimonial pt-5 pb-4">
    <div class="main-container">
        <div class="h_service-title">
            <h2><b>Testimonial</b> Words from our trusted clients</h2>
            <p>Customer satisfaction is a powerful indicator of success; read our testimonials to see firsthand how our solutions have benefited companies all over the world.</p>
        </div>
        <div class="swiper testimonials mb-5">
            <div class="swiper-wrapper" id="testimonialsData">
                <div class="swiper-slide">
                    <div class="testimonials-block text-center">
                        <div class="testimonials-title">Sujeet Mishra,<span>Primers</span></div>
                        <p class="text-center">Working with VYAPAR KRANTI is a game-changer for our online presence. They effortlessly turned our vision into a visually stunning and user-friendly website. The team's expertise, attention to detail, and timely delivery exceeded our expectations. Our new site has not only garnered positive feedback but also positively impacted our business. Highly recommend VYAPAR KRANTI for exceptional website development."</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonials-block text-center">
                        <div class="testimonials-title">Gagan Vyas, <span>Vedikant</span></div>
                        <p class="text-center">Our experience with VYAPAR KRANTI was phenomenal! They transformed our vision into a sleek and functional website. The team's expertise, attention to detail, and commitment to timelines exceeded our expectations. Our new site has boosted our online presence, and we highly recommend VYAPAR KRANTI for top-notch website development.</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonials-block text-center">
                        <div class="testimonials-title">Kundan Kumar</div>
                        <p class="text-center">We collaborated with VYAPAR KRANTI for our website development, and the results speak for themselves. Their team seamlessly translated our vision into a visually stunning and user-friendly site. The level of professionalism, expertise, and on-time delivery exceeded our expectations. We highly recommend VYAPAR KRANTI for anyone seeking top-tier website development.</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="testimonials-block text-center">
                        <div class="testimonials-title">Priti Kohli</div>
                        <p class="text-center">Our experience with VYAPAR KRANTI was nothing short of exceptional. Their team seamlessly translated our vision into a sleek and functional website. The attention to detail, efficient project management, and creative input made the entire process effortless. We're thrilled with the final result.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <section class="newsletter-main-container">
    <div class="main-container">
        <div class="h_service-title">
            <h2>Get on the list!</h2>
            <p>Sign up with your email address to receive news and updates.</p>
        </div>
        <div class="newsletter-input-box">
            <div class="input-box">
            <input type="email" placeholder="Email:"><span class="newsletter-btn"><button type="button">Go</button></span>
            </div>
        </div>
    </div>
</section> -->
<!-- <section class="get-enquery">
    <div class="custom-container">
        <div class="get-enquery-block">
            <h5>"When <b>Innovation</b> will <b>TALK &amp; Design</b> will Visualize, Then Brands <b>Will REACH.</b>"</h5>
            <a href="https://dev.vyaparkranti.in/book365days/public/contact-us">Enquery Now</a>
        </div>
    </div>
</section> -->
<!-- Footer section -->
<section id="footer-section" class="pt-5 pb-4">
    <div class="main-container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="footer-social">
                    <div class="brand-logo">
                        <img src="assets/img/logo_3d.png" class="img-fluid" width="" height="" alt="Vyaparkranti" />
                    </div>
                </div>
        {{-- <div class="h_service-title">
            <h2>Get on the list!</h2>
            <p>Sign up with your email address to receive news and updates.</p>
        </div>
        <div class="newsletter-input-box">
            <div class="input-box">
            <input type="email" placeholder="Email:"><span class="newsletter-btn"><button type="button">Go</button></span>
            </div>
        </div> --}}
                <ul class="social-media pt-4">
                    <li><a style="background-color: #0f90f2;" href="https://www.facebook.com/vyaparkranti" aria-label="Read more about Vyapar Kranti Facebook" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
                    <li><a style="background-color: #c80b7d;" href="https://www.instagram.com/vyaparkranti/" aria-label="Read more about Vyapar Kranti instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    <li><a style="background-color: #317daf;" href="https://www.linkedin.com/company/vyapar-kranti/" aria-label="Read more about Vyapar Kranti linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    <li><a style="background-color: #31ba43;" href="https://wa.me/+919958224825?text=Let%27s+start+build+a+project" aria-label="Read more about Vyapar Kranti whatsapp" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                    <li><a style="background-color: #ff0000;" href="https://www.youtube.com/@VyaparKranti" aria-label="Read more about Vyapar Kranti Youtube" target="_blank"><i class="fa fa-youtube"></i></a></li>
                </ul>
                <div class="landing-form col-md-4 col-sm-12 col-12">
                    {{-- <div class="site-title">
                        <h2 class="text-center">Enquiry Now</h2>
                    </div> --}}
                    <form id="contactFormSubmitbottom" action="javascript:">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name_bottom" name="name"
                                        placeholder="Your Name" required data-error="Please enter your name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="email" placeholder="Your Email" id="emailId_bottom" class="form-control"
                                        name="emailId" required data-error="Please enter your email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="number" placeholder="Your contact number" id="contact_number_bottom" class="form-control"
                                        name="contact_number" required data-error="Please enter contact your number">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea onchange="refreshCapthca('captcha_img_id_contact_us_bottom','captcha_text_contactUsbottom')" class="form-control" id="message_bottom" name="message" placeholder="Your Message" rows="3" data-error="Write your message"
                                        required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="row">
                                    <div class="col-md-12 form-group form-inline">
                                        <div class="col-8 p-0">
                                            <img src="{{ captcha_src() }}" class="img-thumbnail" name="captcha_img" alt="Vyapar Kranti"
                                                id="captcha_img_id_contact_us_bottom">
                                        </div>
                                        <div class="col-4">
                                            <button style="padding:.6em" type="button" 
                                                class="btn btn-common" onclick="refreshCapthca('captcha_img_id_contact_us_bottom','captcha_text_contactUsbottom')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                                    <path fill-rule="evenodd"
                                                        d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter Text in image" class="form-control"
                                        name="captcha" id="captcha_text_contactUsbottom" required />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="submit-button">
                                    <button class="btn btn-common submitbutton" id="submit_bottom" type="submit">SEND MESSAGE</button>
                                    <div id="msgSubmit" class="h3 hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
           
    </div>
</section>
<a class="footer-whatsapp footer-call" aria-label="Phone Call Button" href="tel:+919958224825"><img src="./assets/img/phone-call.png" alt="Phone Call" class="img-fluid" height="" width="150"></a>
<a class="footer-whatsapp" aria-label="Whatsapp Button" href="https://wa.me/+919958224825?text=Hi%2C+Vyapar+kranti"><img src="./assets/img/whatsapp.png" alt="Whatsapp" class="img-fluid" height="" width="150"></a>
<!-- end section --> 
<style>
.portfolio-figure {
    height: 300px;
    width: 100%;
    cursor: pointer;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0px 1px 15px -5px #00000070;
}
.portfolio-figure a > img {
    position: relative;
    width: 100%;
    top: 0%;
    transform: translateY(0);
    -webkit-transform: translateY(0);
    transition: all 3s ease-in-out;
    -webkit-transition: all 3s ease-in-out;
}
.portfolio-figure:hover a > img {
    transform: translateY(-100%);
    top: 100%;
}


    /* review section */
    #review .h_service-title h2,#review .h_service-title p{color: #fff}
.testimonial {
    background-color: var(--vbrown-color);
    box-shadow: inset var(--box-shadow);
}
.testimonials-block {
    max-width: 1000px;
    margin: 2rem auto 0rem;
}
.testimonials-title {
    font: 400 24px/normal var(--vfont-poppins);
    display: inline-block;
    margin: 5px 0 10px;
    text-transform: uppercase;
    color: #fff;
}
.testimonials-block p {
    position: relative;
    padding: 1rem 3rem;
    color: #fff;
    font: 400 20px/normal var(--vfont-poppins);
    text-align: center;
    margin-bottom: 0;
}
.testimonials-block p::after, .testimonials-block p::before {
    content: '\f10d';
    font-family: 'fontAwesome';
    color: var(--vlightbrown-color);
    position: absolute;
    top: 0;
    left: 0;
    font-size: 40px;
}
.testimonials-block p::after{
    content: '\f10e';
    top: unset;
    left: unset;
    bottom: 0;
    right: 0;
}
.testimonials-title span {
    font: italic 700 18px/normal var(--vfont-poppins);
    text-transform: capitalize;
    display: block;
    color: var(--vlightbrown-color);
}
.testimonials-block span.testimonials-title + p {
    /* color: rgb(var(--blue-color) / 80%);
    margin-bottom: 0;
    font: 400 14px/normal var(--font-josefin); */
}
.footer-social .brand-logo > img {
    max-width: 150px;
    text-align: center;
}

ul.social-media {
    list-style: none;
    display: inline-block;
    margin: auto;
}
ul.social-media li {
    display: inline-block;
}
ul.social-media li > a {
    height: 40px;
    width: 40px;
    background-color: lightgray;
    display: block;
    line-height: 40px;
    color: #fff;
    border-radius: 8px;
}
a.footer-whatsapp {
    position: fixed;
    bottom: 25px;
    max-width: 50px;
    left: 15px;
    z-index: 999;
}
a.footer-call {
    bottom: 80px;
    padding: 5px;
}
@media(max-width: 767px){
    .navigation-bar .main-container {
        margin: 0px auto 0rem;
        text-align: center;
        padding: 10px 15px;
        align-items: center;
    }
    .landing-form {
        max-width: calc(100% - 30px);
        margin: 2rem 15px;
    }
    .fixed-content {
        width: calc(100% - 350px);
        padding: 4rem 15px;
    }
    .footer-social .brand-logo {
        display: block;
    }
    .side-navigation > ul li:not(:last-child) {
        display: none;
    }
}
/* review section End */

.package-section{
    padding:30px 0 10px;
}
.package-container{cursor: pointer;padding: 15px;box-shadow: 0px 10px 12px -1px rgba(0 0 0 / 18%);transition: 0.3s all ease-in-out; border-radius: 8px;height: 100%;border: 1px solid rgba(0 0 0 / 10%);padding-bottom: 60px;position: relative;transform: scale(1);text-align: center}
.package-container:hover{box-shadow: 0px 0px 18px -1px rgba(0 0 0 / 18%);transform: scale(1.05);}
.package-container ul{list-style: none;}
.package-price .price-ammount {font: 700 24px/normal var(--vfont-poppins);}
.package-price .price-strike-ammount {text-decoration: line-through !important;}
.package-price + p {font: 400 12px/normal sans-serif;text-align: left;}
.package-list li > p{font-size: 13px;text-align: center;}
.select-packege-query {position: absolute;width: calc(100% - 30px);bottom: 10px;}
.select-packege-query > button.btn {width: 100%;border-radius: 50px;}
.landingpage button.btn.btn-common {
    background-color: transparent;
    color: var(--vbrown-color) !important;
    border: 1px solid var(--vbrown-color);
    border-radius: 8px;
    font: 700 12px/35px var(--vfont-quicksand);
}
.landingpage button.btn.btn-common:hover {
    background-color: var(--vbrown-color) !important;
    color: #fff !important;
}
.landing-form{
    max-width:1000px;
}
/* .newsletter-main-container{
    padding:30px 15px;
    background-color:#ff9;
}
.newsletter-input-box .input-box{
    margin: 30px auto 10px;
}
.newsletter-input-box{
    margin:auto;
    max-width:550px;
}
.input-box input{
    padding:5px 10px;
    border-radius:10px;
    width:500px;
    margin-right:5px;
    }
.input-box button{
    padding:5px 10px;
    border-radius:10px;
    background-color:blue;
    color:#fff;
}
section.get-enquery {
    background-color: rgb(var(--red-color));
    padding:0 15px;
}
.get-enquery-block {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 100%;
    padding: 1rem 0;
    grid-gap: 10px;
}
.get-enquery-block > h5 {
    margin: 0 0;
    font: 700 18px/normal var(--nuto-font);
    color: #fff;
}
.get-enquery-block > a {
    height: 40px;
    font: 700 14px/40px var(--nuto-font);
    padding: 0 15px;
    background-color: #fff;
    color: rgb(var(--red-color));
    border-radius: 4px;
    transition: var(--transition);
}
.get-enquery-block > a:hover {
    background-color: rgb(var(--black-color));
    color: #fff;
} */
/* .newsletter-main-container{
    padding:10px 15px;
} */
</style>
@endsection

{{-- @section('pageScript')
<script type="text/javascript"></script>
@endsection --}}
@section('pageScript')
    @include('WebSitePages.scripts.contactUsScript')
@endsection