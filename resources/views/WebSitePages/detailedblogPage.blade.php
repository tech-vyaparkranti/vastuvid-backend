@extends('layout.app_layout')
@section('title', 'Blog Detail')
@section('bodyClass', 'blog_page')
@section('content')
    <!-- Start Banner -->
    <section class="pagee-strip">
        <div class="main-container">
            <h1>Blog Detail</h1>        
        </div>
    </section>
    <!-- end Banner -->

    <div class="main-container">
        <div class="row">
            <div class="col-md-12">
                <div class="h_service-title">
                    <h2>Detailed Blog</h2>
                </div>
            </div>
        </div>
        <div class="detail-blog-container row mt-4">
            <div class="blog-left-container col-md-9 col-sm-12 col-12 mb-3">
                <div class="blog-left-item">
                    <img src="./assets/images/blog-1.jpg" alt="">
                <div class="blog-left-content">
                    <ul class="detailedblog-social-links mt-3">
                        <li class="twitter"><a href="/"><i class="fa-brands fa-twitter"></i>&nbsp;&nbsp;Twitter</a></li>
                        <li class="instagram"><a href="/"><i class="fa-brands fa-instagram"></i>&nbsp;&nbsp;Instagram</a></li>
                        <li class="linkedin"><a href="/"><i class="fa-brands fa-linkedin"></i>&nbsp;&nbsp;Linkedin</a></li>
                        <li class="facebook"><a href="/"><i class="fa-brands fa-facebook-f"></i>&nbsp;&nbsp;Facebook</a></li>
                    </ul>
                    <p class="blog-date">04 November,2024</p>
                    <h3>A Beginner's Guide to Survey Data Analysis and Data Collection.</h3>
                    <p class="text-justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam nostrum reiciendis commodi eveniet repudiandae quibusdam, ipsam assumenda molestiae officiis natus totam fugit saepe cum quis itaque obcaecati quos atque quasi fugiat autem laborum corporis maxime rerum. Ullam corrupti consectetur quidem sed sapiente odio voluptate. Ratione quaerat laboriosam placeat dolores quisquam ea, repellat iure neque, dolorem adipisci, blanditiis quos quia nulla maxime odit! Numquam aspernatur sunt, aliquid harum iure quibusdam porro facere dolores quas. Aperiam, explicabo ut quibusdam unde beatae maxime officiis dolore exercitationem consectetur, totam delectus illo amet incidunt nulla ab, voluptate doloremque. Officiis, iure? Qui officia vitae commodi dolorum. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi non hic magnam distinctio officiis totam laudantium voluptatem harum quos a quidem repudiandae fugiat magni corporis quam error assumenda quaerat dicta, vitae ex ullam recusandae mollitia? Quis consequatur ad tenetur laborum eum similique illo. Eum quos id maiores voluptates, quas corrupti quo fuga perspiciatis distinctio. Reprehenderit, itaque error. Cumque aliquid mollitia quae dolorem provident quasi rem, repellat dicta aperiam nobis, facere odio placeat libero deserunt fuga voluptate qui illo quos? Recusandae quisquam inventore pariatur aspernatur aperiam quae nisi, nobis saepe atque porro, temporibus, nam sapiente quo molestiae esse beatae ducimus ullam?</p>
                    <h5>Lorem ipsum dolor sit amet.</h5>
                    <p class="text-justify">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non architecto facilis, optio cum reiciendis repellat iure eveniet expedita saepe eius, doloremque ipsam minima possimus qui neque. Sit laudantium consequuntur expedita voluptatibus reiciendis id hic explicabo neque odio in delectus debitis aliquid quis laboriosam vitae dolorem aspernatur quam ab aliquam blanditiis quos, mollitia nisi eius quasi. Quibusdam eaque quos velit reprehenderit laborum ipsa accusantium, odit est labore. Odio et velit in numquam accusantium voluptatibus magnam aliquid quaerat veritatis, animi fugit neque ad, alias non impedit eius totam. Ducimus voluptas modi voluptates maiores nulla, dicta soluta vero adipisci inventore. Eum, ea excepturi?</p>
                </div>
            </div>
            </div>
            <div class="blog-right-container col-md-3 col-sm-12 col-12 mb-3">
                <div class="links">
                    <p><a href="">Podcasts</a></p><hr>
                    <p><a href="">Podcasts</a></p><hr>
                    <p><a href="">Podcasts</a></p><hr>
                    <p><a href="">Podcasts</a></p><hr>
                    <p><a href="">Podcasts</a></p><hr>
                    <p><a href="">Podcasts</a></p>
                </div>
                <div class="recent-posts">
                    <h4>Our Recent Posts</h4>
                    <div class="posts">
                        <div class="post-cards">
                            <img src="./assets/images/blog-2.jpg" alt="">
                            <h5>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit.</h5>
                        </div>
                        <div class="post-cards">
                            <img src="./assets/images/blog-2.jpg" alt="">
                            <h5>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit.</h5>
                        </div>
                        <div class="post-cards">
                            <img src="./assets/images/blog-2.jpg" alt="">
                            <h5>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit.</h5>
                        </div>
                        <div class="post-cards">
                            <img src="./assets/images/blog-2.jpg" alt="">
                            <h5>Lorem ipsum dolor sit amet. Lorem ipsum dolor sit.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pageScript')
<script type="text/javascript"></script>
@endsection