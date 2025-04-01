<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>



<div class=" pt-3 pb-5">
    <div class="py-3"></div><!-- End .mb-3 -->
    <div class="container">
        <div class="heading heading-flex heading-border mb-3">
            <div class="heading-left">
                <h2 class="title">Products</h2><!-- End .title -->
            </div><!-- End .heading-left -->

            <div class="heading-right">
                <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="allproduct-all-link" data-toggle="tab" href="#allproduct-all-tab" role="tab"
                            aria-controls="allproduct-all-tab" aria-selected="true">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="allproduct-elec-link" data-toggle="tab" href="#allproduct-elec-tab" role="tab"
                            aria-controls="allproduct-elec-tab" aria-selected="false">Table Wood
                            Lamp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="allproduct-furn-link" data-toggle="tab" href="#allproduct-furn-tab" role="tab"
                            aria-controls="allproduct-furn-tab" aria-selected="false">Woodwork
                            Lights</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="allproduct-clot-link" data-toggle="tab" href="#allproduct-clot-tab" role="tab"
                            aria-controls="allproduct-clot-tab" aria-selected="false">Breaker</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="allproduct-acc-link" data-toggle="tab" href="#allproduct-acc-tab" role="tab"
                            aria-controls="allproduct-acc-tab" aria-selected="false">Cable</a>
                    </li>
                </ul>
            </div><!-- End .heading-right -->
        </div><!-- End .heading -->

        <div class="tab-content tab-content-carousel">
            <div class="tab-pane p-0 fade show active" id="allproduct-all-tab" role="tabpanel" aria-labelledby="allproduct-all-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                                    "nav": false, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":1
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":2
                                        },
                                        "992": {
                                            "items":3
                                        },
                                        "1280": {
                                            "items":4,
                                            "nav": true
                                        }
                                    }
                                }'>
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-top">Top</span>
                            <span class="product-label label-sale">Sale</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/butterfly table lamp.png" alt="Product image"
                                    class="fixed-height-img">
                            </a>

                            <div class="product-countdown" data-until="+9h" data-format="HMS" data-relative="true"
                                data-labels-short="true"></div>
                            <!-- End .product-countdown -->

                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Table Wood Lamp</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Bose - SoundSport wireless
                                    headphones</a></h3><!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 179.99</span>
                                <span class="old-price">Was ETB 199.99</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 4 Reviews )</span>
                            </div><!-- End .rating-container -->


                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/Breaker 1.png" alt="Product image"
                                    class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Kalki</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->



                </div><!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->
            <div class="tab-pane p-0 fade" id="allproduct-elec-tab" role="tabpanel" aria-labelledby="allproduct-elec-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                                    "nav": false, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":1
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":2
                                        },
                                        "992": {
                                            "items":3
                                        },
                                        "1280": {
                                            "items":4,
                                            "nav": true
                                        }
                                    }
                                }'>
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div><!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->
            <div class="tab-pane p-0 fade" id="allproduct-furn-tab" role="tabpanel" aria-labelledby="allproduct-furn-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                                    "nav": false, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":1
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":2
                                        },
                                        "992": {
                                            "items":3
                                        },
                                        "1280": {
                                            "items":4,
                                            "nav": true
                                        }
                                    }
                                }'>
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div><!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->
            <div class="tab-pane p-0 fade" id="allproduct-clot-tab" role="tabpanel" aria-labelledby="allproduct-clot-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                                    "nav": false, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":1
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":2
                                        },
                                        "992": {
                                            "items":3
                                        },
                                        "1280": {
                                            "items":4,
                                            "nav": true
                                        }
                                    }
                                }'>
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div><!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->
            <div class="tab-pane p-0 fade" id="allproduct-acc-tab" role="tabpanel" aria-labelledby="allproduct-acc-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                                    "nav": false, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":1
                                        },
                                        "480": {
                                            "items":2
                                        },
                                        "768": {
                                            "items":2
                                        },
                                        "992": {
                                            "items":3
                                        },
                                        "1280": {
                                            "items":4,
                                            "nav": true
                                        }
                                    }
                                }'>
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->

                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <div class="product">
                        <figure class="product-media">
                            <span class="product-label label-sale">Sales</span>
                            <a href="product.html">
                                <img src="static/assets/images/Temp files/rectangle_wooden_pendant.png"
                                    alt="Product image" class="fixed-height-img">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                                        to wishlist</span></a>
                                <a href="#" class="btn-product-icon btn-compare"
                                    title="Compare"><span>Compare</span></a>
                                <a href="static/popup/quickView.html" class="btn-product-icon btn-quickview"
                                    title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart" title="Add to cart"><span>add to
                                        cart</span></a>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="#">Woodwork Lights</a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.html">Rectangle Wooden Pendant</a>
                            </h3>
                            <!-- End .product-title -->
                            <div class="product-price">
                                <span class="new-price">ETB 251.99</span>
                                <span class="old-price">Was ETB 290.00</span>
                            </div><!-- End .product-price -->
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    <!-- End .ratings-val -->
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( 2 Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div><!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->
        </div><!-- End .tab-content -->
    </div><!-- End .container -->
</div><!-- End .bg-light pt-5 pb-5 -->
