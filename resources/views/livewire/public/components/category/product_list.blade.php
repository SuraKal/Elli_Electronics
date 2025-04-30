<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="container">

    {{-- Update the   id="elec-new-link" part for each slidder to be different--}}
    <div class="py-3"></div><!-- End .mb-3 -->
    <div class="heading heading-flex heading-border mb-3">
        <div class="heading-left">
            <h2 class="title">Table Wood Lamp</h2><!-- End .title -->
        </div><!-- End .heading-left -->

        <div class="heading-right">
            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="elec-new-link" data-toggle="tab" href="#elec-new-tab" role="tab"
                        aria-controls="elec-new-tab" aria-selected="true">New</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="elec-featured-link" data-toggle="tab" href="#elec-featured-tab" role="tab"
                        aria-controls="elec-featured-tab" aria-selected="false">Featured</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="elec-best-link" data-toggle="tab" href="#elec-best-tab" role="tab"
                        aria-controls="elec-best-tab" aria-selected="false">Best Seller</a>
                </li>
            </ul>
        </div><!-- End .heading-right -->
    </div><!-- End .heading -->

    <div class="tab-content tab-content-carousel">
        <div class="tab-pane p-0 fade show active" id="elec-new-tab" role="tabpanel" aria-labelledby="elec-new-link">
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                                    "nav": false, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": true,
                                    "autoplay": true,  
                                    "autoplayTimeout": 4000, 
                                    "autoplayHoverPause": true,
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
                <livewire:public.components.product.single />

                <livewire:public.components.product.single />
                <livewire:public.components.product.single />
                <livewire:public.components.product.single />
            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
        <div class="tab-pane p-0 fade" id="elec-featured-tab" role="tabpanel" aria-labelledby="elec-featured-link">
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
                <livewire:public.components.product.single />

                <livewire:public.components.product.single />
                <livewire:public.components.product.single />
                <livewire:public.components.product.single />
            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
        <div class="tab-pane p-0 fade" id="elec-best-tab" role="tabpanel" aria-labelledby="elec-best-link">
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
                <livewire:public.components.product.single />

                <livewire:public.components.product.single />
                <livewire:public.components.product.single />
                <livewire:public.components.product.single />
            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
    </div><!-- End .tab-content -->
</div><!-- End .container -->
