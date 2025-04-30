<?php
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Services\CategoryService;

new #[Layout('components.layouts.guest')] class extends Component
{


};
?>

<main class="main">
    <div class="intro-slider-container">
        <div class="intro-slider owl-carousel owl-simple owl-nav-inside" data-toggle="owl" data-owl-options='{
                        "nav": false,
                        "dots": true,
                        "margin": 30,
                        "loop": true, 
                        "autoplay": true,  
                        "autoplayTimeout": 3000,  
                        "smartSpeed": 800, 
                        "slideTransition": "linear", 
                        "responsive": {
                            "992": {
                                "nav": true
                            }
                        }
                    }'>
                    {{-- static/assets/images/demos/demo-13/slider/slide-1.png --}}
            <div class="intro-slide"
                style="background-image: url(static/images/slidder/slidder1.jpg);">
                <div class="container intro-content">
                    <div class="row">
                        <div class="col-auto offset-lg-3 intro-col">
                            <h3 class="intro-subtitle">Trade-In Offer</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title">WoodWork  <br>Lights
                                <span>
                                    <sup class="font-weight-light">from</sup>
                                    <span class="text-primary">ETB 111<sup>,99</sup></span>
                                </span>
                            </h1><!-- End .intro-title -->

                            <a href="{{ route('public.category.index') }}" class="btn btn-outline-primary-2">
                                <span>Shop Now</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .col-auto offset-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->

            <div class="intro-slide"
                style="background-image: url(static/images/slidder/slidder2.jpg);">
                <div class="container intro-content">
                    <div class="row">
                        <div class="col-auto offset-lg-3 intro-col">
                            <h3 class="intro-subtitle">Trevel & Outdoor</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title">Original Outdoor <br>Beanbag
                                <span>
                                    <sup class="font-weight-light line-through">$89,99</sup>
                                    <span class="text-primary">ETB 29<sup>,99</sup></span>
                                </span>
                            </h1><!-- End .intro-title -->

                            <a href="{{ route('public.category.index') }}" class="btn btn-outline-primary-2">
                                <span>Shop Now</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .col-auto offset-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->

            <div class="intro-slide"
                style="background-image: url(static/images/slidder/slidder3.jpg);">
                <div class="container intro-content">
                    <div class="row">
                        <div class="col-auto offset-lg-3 intro-col">
                            <h3 class="intro-subtitle">Fashion Promotions</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title">Tan Suede <br>Biker Jacket
                                <span>
                                    <sup class="font-weight-light line-through">ETB 240,00</sup>
                                    <span class="text-primary">ETB 180<sup>,99</sup></span>
                                </span>
                            </h1><!-- End .intro-title -->

                            <a href="{{ route('public.category.index') }}" class="btn btn-outline-primary-2">
                                <span>Shop Now</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .col-auto offset-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->
        </div><!-- End .owl-carousel owl-simple -->

        <span class="slider-loader"></span><!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->


    <livewire:public.components.category.popular_categories />


    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="banner banner-overlay">
                    <a href="#">
                        <img src="static/assets/images/demos/demo-13/banners/banner-1.jpg" alt="Banner">
                    </a>

                    <div class="banner-content">
                        <h4 class="banner-subtitle text-white"><a href="#">Weekend Sale</a></h4>
                        <!-- End .banner-subtitle -->
                        <h3 class="banner-title text-white"><a href="#">Lighting <br>& Accessories <br><span>25%
                                    off</span></a></h3><!-- End .banner-title -->
                        <a href="#" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
                    </div><!-- End .banner-content -->
                </div><!-- End .banner -->
            </div><!-- End .col-lg-3 -->

            <div class="col-sm-6 col-lg-3 order-lg-last">
                <div class="banner banner-overlay">
                    <a href="#">
                        <img src="static/assets/images/demos/demo-13/banners/banner-3.jpg" alt="Banner">
                    </a>

                    <div class="banner-content">
                        <h4 class="banner-subtitle text-white"><a href="#">Smart Offer</a></h4>
                        <!-- End .banner-subtitle -->
                        <h3 class="banner-title text-white"><a href="#">Anniversary <br>Special <br><span>15%
                                    off</span></a></h3><!-- End .banner-title -->
                        <a href="#" class="banner-link">Shop Now <i class="icon-long-arrow-right"></i></a>
                    </div><!-- End .banner-content -->
                </div><!-- End .banner -->
            </div><!-- End .col-lg-3 -->

            <div class="col-lg-6">
                <div class="banner banner-overlay">
                    <a href="#">
                        <img src="static/assets/images/demos/demo-13/banners/banner-2.jpg" alt="Banner">
                    </a>

                    <div class="banner-content">
                        <h4 class="banner-subtitle text-white d-none d-sm-block"><a href="#">Amazing Value</a>
                        </h4><!-- End .banner-subtitle -->
                        <h3 class="banner-title text-white"><a href="#">Woodwork Lights<br>Collection
                                2025 <br><span>from ETB 1299</span></a></h3><!-- End .banner-title -->
                        <a href="#" class="banner-link">Discover Now <i class="icon-long-arrow-right"></i></a>
                    </div><!-- End .banner-content -->
                </div><!-- End .banner -->
            </div><!-- End .col-lg-6 -->
        </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="mb-3"></div><!-- End .mb-3 -->



    {{-- Hot deal Product Section --}}
    <livewire:public.components.product.hot_deal_products />




    <div class="mb-3"></div><!-- End .mb-3 -->

    {{-- Hot deal Product Section --}}
    <livewire:public.components.product.all_products/>




    <div class="mb-3"></div><!-- End .mb-3 -->

    {{-- Hot deal Product Section --}}
    <livewire:public.components.product.trending_products />

    <div class="mb-3"></div><!-- End .mb-3 -->


    {{-- <livewire:public.components.category.product_list /> --}}


    <div class="mb-3"></div><!-- End .mb-3 -->

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="banner banner-overlay banner-overlay-light">
                    <a href="#">
                        <img src="static/assets/images/demos/demo-13/banners/banner-4.jpg" alt="Banner">
                    </a>

                    <div class="banner-content">
                        <h4 class="banner-subtitle d-none d-sm-block"><a href="#">Spring Sale is Coming</a></h4>
                        <!-- End .banner-subtitle -->
                        <h3 class="banner-title"><a href="#">All Smart Watches <br>Discount <br><span
                                    class="text-primary">15% off</span></a></h3><!-- End .banner-title -->
                        <a href="#" class="banner-link banner-link-dark">Discover Now <i
                                class="icon-long-arrow-right"></i></a>
                    </div><!-- End .banner-content -->
                </div><!-- End .banner -->
            </div><!-- End .col-lg-6 -->

            <div class="col-lg-6">
                <div class="banner banner-overlay">
                    <a href="#">
                        <img src="static/assets/images/demos/demo-13/banners/banner-5.png" alt="Banner">
                    </a>

                    <div class="banner-content">
                        <h4 class="banner-subtitle text-white  d-none d-sm-block"><a href="#">Amazing Value</a>
                        </h4><!-- End .banner-subtitle -->
                        <h3 class="banner-title text-white"><a href="#">Headphones Trending <br>JBL Harman
                                <br><span>from $59,99</span></a></h3><!-- End .banner-title -->
                        <a href="#" class="banner-link">Discover Now <i class="icon-long-arrow-right"></i></a>
                    </div><!-- End .banner-content -->
                </div><!-- End .banner -->
            </div><!-- End .col-lg-6 -->
        </div><!-- End .row -->
    </div><!-- End .container -->



    <div class="mb-1"></div><!-- End .mb-1 -->

    {{-- <livewire:public.components.category.product_list /> --}}



    <div class="mb-3"></div><!-- End .mb-3 -->

    {{-- <livewire:public.components.category.product_list /> --}}


    <div class="mb-3"></div><!-- End .mb-3 -->

    <livewire:public.components.category.popular_categories />





    <livewire:public.components.section.email_subscription />




</main><!-- End .main -->
