<?php

use Livewire\Volt\Component;
use App\Services\CategoryService;


new class extends Component {

    // get it in $this->categories
    public function getCategoriesProperty(CategoryService $categoryService)
    {
        return $categoryService->getCategoriesActive()
            ->select('uuid', 'name', 'image','slug')
            ->latest()
            ->get();
    }



}; ?>

<div class="container">
    <div class="py-4"></div>
    <h2 class="title text-center mb-2">Explore Popular Categories</h2>

    <div class="owl-carousel mb-5 owl-simple" data-toggle="owl" data-owl-options='{
        "nav": false, 
        "dots": true,
        "margin": 30,
        "loop": true, 
        "autoplay": true, 
        "autoplayTimeout": 3000,  
        "autoplayHoverPause": true,  
        "responsive": {
            "0": {
                "items":2
            },
            "420": {
                "items":3
            },
            "600": {
                "items":4
            },
            "900": {
                "items":5
            },
            "1024": {
                "items":6
            },
            "1280": {
                "items":6,
                "nav": true,
                "dots": false
            }
        }
    }'>
        @foreach($this->categories as $category)
            <a href="{{ route('public.category.products.index', $category->slug) }}" class="cat-block">
                <figure>
                    <span>
                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }} image"
                            class="img-fluid w-50 h-50">
                    </span>
                </figure>
                <h3 class="cat-block-title">{{ $category->name }}</h3>
            </a>
        @endforeach
{{-- 


        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/Woodwork Lights Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Woodwork Lights</h3>
        </a>

        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/Table Wood Lamp Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Table Wood Lamp</h3>
        </a>

        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/Breaker Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Breaker</h3>
        </a>

        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/junction-box Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Junction Box</h3>
        </a>

        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/Wire Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Wire</h3>
        </a>

        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/Cable Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Cable</h3>
        </a>
        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/Table Wood Lamp Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Table Wood Lamp</h3>
        </a>

        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/Breaker Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Breaker</h3>
        </a>

        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/junction-box Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Junction Box</h3>
        </a>

        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/Wire Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Wire</h3>
        </a>

        <a href="{{ route('public.category.product.index') }}" class="cat-block">
            <figure>
                <span>
                    <img src="static/assets/images/Temp files/Cable Category Image.png" alt="Category image"
                        class="img-fluid w-50 h-50">
                </span>
            </figure>
            <h3 class="cat-block-title">Cable</h3>
        </a> --}}
    </div> <!-- End .owl-carousel -->
</div>
