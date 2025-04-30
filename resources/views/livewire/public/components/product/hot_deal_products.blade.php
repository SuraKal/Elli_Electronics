<?php

use Livewire\Volt\Component;
use App\Services\ProductService;
use App\Services\CategoryService;


new class extends Component {
    public $hot_deal_products = [];
    public $categories;


    public function mount(ProductService $product_service,CategoryService $categoryService){ 
        $this->hot_deal_products = $product_service->hotdealproducts();

        $this->categories = $categoryService->getCategoriesActive()
            ->select('name','slug','uuid','id')
            ->latest()
            ->get();


    }

    
}; ?>



<div class="bg-light pt-3 pb-5">
    <div class="py-3"></div><!-- End .mb-3 -->
    <div class="container">
        <div class="heading heading-flex heading-border mb-3">
            <div class="heading-left">
                <h2 class="title">Hot Deals Products</h2><!-- End .title -->
            </div><!-- End .heading-left -->

            <div class="heading-right">
                <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="allproduct-all-link" data-toggle="tab" href="#allproduct-all-tab"
                            role="tab" aria-controls="allproduct-all-tab" aria-selected="true">All</a>
                    </li>

                    @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link" id="allproduct-{{ $category->slug }}-link" data-toggle="tab"
                            href="#allproduct-{{ $category->slug }}-tab" role="tab"
                            aria-controls="allproduct-{{ $category->slug }}-tab" aria-selected="false">
                            {{ $category->name }}</a>
                    </li>
                    @endforeach

                    {{-- <li class="nav-item">
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
                    </li> --}}




                </ul>
            </div><!-- End .heading-right -->
        </div><!-- End .heading -->

        <div class="tab-content tab-content-carousel">







            <div class="tab-pane p-0 fade show active" id="allproduct-all-tab" role="tabpanel"
                aria-labelledby="allproduct-all-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                                    "nav": false, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
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
                    @foreach($hot_deal_products as $product)
                        <livewire:public.components.product.individual :product="$product" />
                    @endforeach




                </div><!-- End .owl-carousel -->
            </div><!-- .End .tab-pane -->

            @foreach($categories as $category)
            <div class="tab-pane p-0 fade" id="allproduct-{{ $category->slug }}-tab" role="tabpanel"
                aria-labelledby="allproduct-{{ $category->slug }}-link">

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



                    @foreach($category->hotdealproducts() as $product)
                        <livewire:public.components.product.individual :product="$product" />
                    @endforeach

                </div><!-- End .owl-carousel -->
            </div><!-- End .tab-pane -->
            @endforeach
        </div><!-- End .tab-content -->
    </div><!-- End .container -->
</div><!-- End .bg-light pt-5 pb-5 -->
