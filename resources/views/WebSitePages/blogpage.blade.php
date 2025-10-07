@extends('layout.app_layout')
@section('title', 'Blog')
@section('bodyClass', 'blog_page')
@section('content')
    <!-- Start Banner -->
    <section class="pagee-strip">
        <div class="main-container">
            <h1>Blogs</h1>        
        </div>
    </section>
    <!-- end Banner -->
    <div class="main-container">
        <div class="row">
            <div class="col-md-12">
                <div class="h_service-title">
                    <h2>Our Blogs</h2>
                </div>
            </div>
        </div>
        <div class="row blog-section">
            @foreach($blogs as $blog)
            <div class="col-md-3 col-sm-12 col-12 blog-card mt-3 mb-3">
                <div class="blog-card-container">
                    <img src="{{ $blogs->blog_image }}" alt="blog image">
                    <div class="card-content">
                        <h4 class="blog_heading">{{ $blog->blog_name }}</h4>
                        <p class="blog-content">{{ $blog->blog_description }}</p>
                        <ul class="blog_social_links mb-3">
                            <li><a href="/"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-linkedin"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-twitter"></i></a></li>
                        </ul>
                        <span><a href="{{ route('detailedblogPage'.$blog->id) }}">Read more<i class="fa-solid fa-arrow-right"></i></a></span>
                    </div>
                </div>
            </div>
        @endforeach
            <div class="col-md-3 col-sm-12 col-12 blog-card mt-3 mb-3">
                <div class="blog-card-container">
                    <img src="./assets/images/img2.png" alt="blog image">
                    <div class="card-content">
                        <h4 class="blog_heading">My New blog</h4>
                        <p class="blog-content">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores, delectus doloribus alias eaque cupiditate inventore odit magni nulla ab expedita exercitationem ducimus nemo dicta.</p>
                        <ul class="blog_social_links mb-3">
                            <li><a href="/"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-linkedin"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-twitter"></i></a></li>
                        </ul>
                        <span><a href="{{ route('detailedblogPage') }}">Read more<i class="fa-solid fa-arrow-right"></i></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-12 blog-card mt-3 mb-3">
                <div class="blog-card-container">
                    <img src="./assets/images/img2.png" alt="blog image">
                    <div class="card-content">
                        <h4 class="blog_heading">My New blog</h4>
                        <p class="blog-content">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores, delectus doloribus alias eaque cupiditate inventore odit magni nulla ab expedita exercitationem ducimus nemo dicta.</p>
                        <ul class="blog_social_links mb-3">
                            <li><a href="/"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-linkedin"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-twitter"></i></a></li>
                        </ul>
                        <span><a href="{{ route('detailedblogPage') }}">Read more<i class="fa-solid fa-arrow-right"></i></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-12 blog-card mt-3 mb-3">
                <div class="blog-card-container">
                    <img src="./assets/images/img2.png" alt="blog image">
                    <div class="card-content">
                        <h4 class="blog_heading">My New blog</h4>
                        <p class="blog-content">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores, delectus doloribus alias eaque cupiditate inventore odit magni nulla ab expedita exercitationem ducimus nemo dicta.</p>
                        <ul class="blog_social_links mb-3">
                            <li><a href="/"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-linkedin"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-twitter"></i></a></li>
                        </ul>
                        <span><a href="{{ route('detailedblogPage') }}">Read more<i class="fa-solid fa-arrow-right"></i></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 col-12 blog-card mt-3 mb-3">
                <div class="blog-card-container">
                    <img src="./assets/images/img2.png" alt="blog image">
                    <div class="card-content">
                        <h4 class="blog_heading">My New blog</h4>
                        <p class="blog-content">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores, delectus doloribus alias eaque cupiditate inventore odit magni nulla ab expedita exercitationem ducimus nemo dicta.</p>
                        <ul class="blog_social_links mb-3">
                            <li><a href="/"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-linkedin"></i></a></li>
                            <li><a href="/"><i class="fa-brands fa-twitter"></i></a></li>
                        </ul>
                        <span><a href="{{ route('detailedblogPage') }}">Read more<i class="fa-solid fa-arrow-right"></i></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('pageScript')
<script type="text/javascript"></script>
@endsection
