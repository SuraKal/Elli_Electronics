<?php

use Livewire\Volt\Component;
use App\Models\Product;
use App\Models\Category;


new class extends Component {
    public Product $product;
    public Category $category;

    public function mount(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
        // dd($this->category);

    }

}; ?>

<div class="product">
    <figure class="product-media fixed-height-img">
        <span class="product-label label-top">Top</span>
        <span class="product-label label-sale">Sale</span>
        <a href="{{ route('public.product.show',$product?->slug) }}">
            <img src="{{ asset($product?->image) }}" alt="Product image"
                class="fixed-height-img">
        </a>

        {{-- <div class="product-countdown" data-until="+9h" data-format="HMS" data-relative="true" data-labels-short="true">
        </div> --}}
        <!-- End .product-countdown -->

        <div class="product-action-vertical">
            <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add
                    to wishlist</span></a>
            <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
            <a href="{{ asset('static/popup/quickView.html') }}" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick
                    view</span></a>
        </div><!-- End .product-action-vertical -->

        
    </figure><!-- End .product-media -->

    <div class="product-body">
        <div class="product-cat">
            <a href=""></a>
        </div><!-- End .product-cat -->
        <h3 class="product-title"><a href="{{ route('public.product.show',$product?->slug ) }}">{{ $product?->name }}</a></h3><!-- End .product-title -->
        <div class="product-price">
            <span class="new-price">ETB {{ $product?->price }}</span>
            {{-- <span class="old-price">Was ETB 199.99</span> --}}
        </div><!-- End .product-price -->
        {{-- <div class="ratings-container">
            <div class="ratings">
                <div class="ratings-val" style="width: 100%;"></div>
                <!-- End .ratings-val -->
            </div><!-- End .ratings -->
            <span class="ratings-text">( 4 Reviews )</span>
        </div><!-- End .rating-container --> --}}

        <div class="">
            <a href="{{ route('public.product.show',$product?->slug) }}" class="btn-product btn-cart rounded" title="Add to cart"><span>Buy</span></a>
        </div><!-- End .product-action -->

    </div><!-- End .product-body -->
</div><!-- End .product -->
