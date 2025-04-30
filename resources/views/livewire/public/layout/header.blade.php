<?php

use Livewire\Volt\Component;
use App\Services\CategoryService;
use App\Services\TagService;
use App\Livewire\Actions\Logout;



new class extends Component {

    public function getCategoriesProperty(CategoryService $categoryService)
    {
        return $categoryService->getCategoriesActive()
            ->select('name','slug')
            ->latest()
            ->get();
    }

    public function getTagsProperty(TagService $tagService)
    {
        return $tagService->getTagsActive()
            ->select('name','slug')
            ->latest()
            ->get();
    }

        /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<header class="header header-10 header-intro-clearance">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <a href="tel:#"><i class="icon-phone"></i>Call: +251 911232839</a>
            </div><!-- End .header-left -->

            <div class="header-right">

                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li class="d-none">
                                <div class="header-dropdown">
                                    <a href="#">USD</a>
                                    <div class="header-menu">
                                        <ul>
                                            <li><a href="#">Eur</a></li>
                                            <li><a href="#">Usd</a></li>
                                        </ul>
                                    </div><!-- End .header-menu -->
                                </div><!-- End .header-dropdown -->
                            </li>
                            <li class="d-none">
                                <div class="header-dropdown">
                                    <a href="#">Engligh</a>
                                    <div class="header-menu">
                                        <ul>
                                            <li><a href="#">English</a></li>
                                            <li><a href="#">French</a></li>
                                            <li><a href="#">Spanish</a></li>
                                        </ul>
                                    </div><!-- End .header-menu -->
                                </div><!-- End .header-dropdown -->
                            </li>
                            <li class="">
                                @guest
                                <div class="header-dropdown">
                                    <a href="#signin-modal" data-toggle="modal">Sign in / Sign up</a>
                                </div><!-- End .header-dropdown -->
                                @endguest
                                @auth
                                <button wire:click="logout" class="d-block w-100 ps-3 pe-4 py-2 border-start border-start-4 border-primary text-start fw-medium text-white bg-primary bg-opacity-10 focus:border-primary focus:bg-opacity-25 focus:text-primary-emphasis transition">
                                        {{ __('Log Out') }}
                                </button>




                                @endauth
                            </li>
                            <!-- <li class="login">
                                        <a href="#signin-modal" data-toggle="modal">Sign in / Sign up</a>
                                    </li> -->
                        </ul>
                    </li>
                </ul><!-- End .top-menu -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-top -->

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('static/assets/images/collections/logo/logo.png') }}" alt="Logo" width="105"
                        height="25">
                </a>

            </div><!-- End .header-left -->

            <div class="header-center">
                <div
                    class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                    <form action="#" method="get">
                        <div class="header-search-wrapper search-wrapper-wide">
                            <div class="select-custom">
                                <select id="cat" name="cat">
                                    <option value="">All Categories</option>

                                    @foreach($this->categories as $category)
                                    <option value="{{ $category->slug }}">
                                        <a href="{{ route('public.category.products.index', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>
                                    </option>
                                    @endforeach
                                </select>
                            </div><!-- End .select-custom -->
                            <label for="q" class="sr-only">Search</label>
                            <input type="search" class="form-control" name="q" id="q" placeholder="Search product ..."
                                required>
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->
            </div>

            <div class="header-right">
                <div class="header-dropdown-link">
                    <div class="dropdown compare-dropdown d-none">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" data-display="static" title="Compare Products"
                            aria-label="Compare Products">
                            <i class="icon-random"></i>
                            <span class="compare-txt">Compare</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="compare-products">
                                <li class="compare-product">
                                    <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                    <h4 class="compare-product-title"><a href="">Blue Night
                                            Dress</a></h4>
                                </li>
                                <li class="compare-product">
                                    <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                    <h4 class="compare-product-title"><a href="">White Long
                                            Skirt</a></h4>
                                </li>
                            </ul>

                            <div class="compare-actions">
                                <a href="#" class="action-link">Clear All</a>
                                <a href="#" class="btn btn-outline-primary-2"><span>Compare</span><i
                                        class="icon-long-arrow-right"></i></a>
                            </div>
                        </div><!-- End .dropdown-menu -->
                    </div><!-- End .compare-dropdown -->

                    <a href="{{ route('shop.wishlist.index') }}" class="wishlist-link">
                        <i class="icon-heart-o"></i>
                        <span class="wishlist-count">3</span>
                        <span class="wishlist-txt">Wishlist</span>
                    </a>

                    <div class="dropdown cart-dropdown">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" data-display="static">
                            <i class="icon-shopping-cart"></i>
                            <span class="cart-count">2</span>
                            <span class="cart-txt">Cart</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-cart-products">
                                <div class="product">
                                    <div class="product-cart-details">
                                        <h4 class="product-title">
                                            <a href="">Twisted Wooden Pendant</a>
                                        </h4>
                                        <!-- twisted wooden pendant
Twisted Wooden Pendant -->
                                        <span class="cart-product-info">
                                            <span class="cart-product-qty">1</span>
                                            x ETB 84.00
                                        </span>
                                    </div><!-- End .product-cart-details -->

                                    <figure class="product-image-container">
                                        <a href="" class="product-image">
                                            <img src="{{ asset('static/assets/images/Temp files/Twisted wooden pendent.jpg') }}"
                                                alt="product">
                                        </a>
                                    </figure>
                                    <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                </div><!-- End .product -->

                                <div class="product">
                                    <div class="product-cart-details">
                                        <h4 class="product-title">
                                            <a href="">Rectangle Wooden Pendant</a>
                                        </h4>

                                        <span class="cart-product-info">
                                            <span class="cart-product-qty">1</span>
                                            x ETB 76.00
                                        </span>
                                    </div><!-- End .product-cart-details -->

                                    <figure class="product-image-container">
                                        <a href="" class="product-image">
                                            <img src="{{ asset('static/assets/images/Temp files/Rectangle wooden pendent.jpg') }}"
                                                alt="product">
                                        </a>
                                    </figure>
                                    <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                </div><!-- End .product -->
                            </div><!-- End .cart-product -->

                            <div class="dropdown-cart-total">
                                <span>Total</span>

                                <span class="cart-total-price">ETB 160.00</span>
                            </div><!-- End .dropdown-cart-total -->

                            <div class="dropdown-cart-action">
                                <a href="{{ route('shop.cart.index') }}" class="btn btn-primary">View Cart</a>
                                <a href="{{ route('shop.transaction.checkout') }}"
                                    class="btn btn-outline-primary-2"><span>Checkout</span><i
                                        class="icon-long-arrow-right"></i></a>
                            </div><!-- End .dropdown-cart-total -->
                        </div><!-- End .dropdown-menu -->
                    </div><!-- End .cart-dropdown -->
                </div>
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->

    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="header-left">
                <div class="dropdown category-dropdown show is-on" data-visible="true">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="true" data-display="static" title="Browse Categories">
                        Browse Categories
                    </a>

                    <div class="dropdown-menu ">
                        <nav class="side-nav">
                            <ul class="menu-vertical sf-arrows">
                                <li class="megamenu-container d-none">
                                    <a class="sf-with-ul" href="#">Electronic</a>

                                    <div class="megamenu">
                                        <div class="row no-gutters">
                                            <div class="col-md-8">
                                                <div class="menu-col">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="menu-title">Laptops & Computers</div>
                                                            <!-- End .menu-title -->
                                                            <ul>
                                                                <li><a href="#">Desktop Computers</a></li>
                                                                <li><a href="#">Monitors</a></li>
                                                                <li><a href="#">Laptops</a></li>
                                                                <li><a href="#">iPad & Tablets</a></li>
                                                                <li><a href="#">Hard Drives & Storage</a></li>
                                                                <li><a href="#">Printers & Supplies</a></li>
                                                                <li><a href="#">Computer Accessories</a></li>
                                                            </ul>

                                                            <div class="menu-title">TV & Video</div>
                                                            <!-- End .menu-title -->
                                                            <ul>
                                                                <li><a href="#">TVs</a></li>
                                                                <li><a href="#">Home Audio Speakers</a></li>
                                                                <li><a href="#">Projectors</a></li>
                                                                <li><a href="#">Media Streaming Devices</a></li>
                                                            </ul>
                                                        </div><!-- End .col-md-6 -->

                                                        <div class="col-md-6">
                                                            <div class="menu-title">Cell Phones</div>
                                                            <!-- End .menu-title -->
                                                            <ul>
                                                                <li><a href="#">Carrier Phones</a></li>
                                                                <li><a href="#">Unlocked Phones</a></li>
                                                                <li><a href="#">Phone & Cellphone Cases</a></li>
                                                                <li><a href="#">Cellphone Chargers </a></li>
                                                            </ul>

                                                            <div class="menu-title">Digital Cameras</div>
                                                            <!-- End .menu-title -->
                                                            <ul>
                                                                <li><a href="#">Digital SLR Cameras</a></li>
                                                                <li><a href="#">Sports & Action Cameras</a></li>
                                                                <li><a href="#">Camcorders</a></li>
                                                                <li><a href="#">Camera Lenses</a></li>
                                                                <li><a href="#">Photo Printer</a></li>
                                                                <li><a href="#">Digital Memory Cards</a></li>
                                                                <li><a href="#">Camera Bags, Backpacks &
                                                                        Cases</a></li>
                                                            </ul>
                                                        </div><!-- End .col-md-6 -->
                                                    </div><!-- End .row -->
                                                </div><!-- End .menu-col -->
                                            </div><!-- End .col-md-8 -->

                                            <div class="col-md-4">
                                                <div class="banner banner-overlay">
                                                    <a href="{{ route('public.category.index') }}"
                                                        class="banner banner-menu">
                                                        <img src="{{ asset('static/assets/images/demos/demo-13/menu/banner-1.jpg') }}"
                                                            alt="Banner">
                                                    </a>
                                                </div><!-- End .banner banner-overlay -->
                                            </div><!-- End .col-md-4 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .megamenu -->
                                </li>

                                @foreach($this->categories as $category)
                                <li><a
                                        href="{{ route('public.category.products.index', $category->slug) }}">{{ $category->name }}</a>
                                </li>
                                @endforeach
                            </ul><!-- End .menu-vertical -->
                        </nav><!-- End .side-nav -->
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .category-dropdown -->
            </div><!-- End .col-lg-3 -->
            <div class="header-center">
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        {{-- <li class="megamenu-container active">
                            <a href="index.html">Home</a>
                        </li> --}}

                        <x-public.nav-link :active="request()->routeIs('home')">
                            <a href="{{ route('home') }}">Home</a>
                        </x-public.nav-link>

                        {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </x-nav-link> --}}

                        <x-public.nav-link :active="request()->routeIs('public.category.index')">
                            <a href="{{ route('public.category.index') }}">Shop</a>
                        </x-public.nav-link>

                        {{-- <li class="megamenu-container ">
                            <a href="{{ route('public.category.index') }}">Shop</a>
                        </li> --}}
                        <x-public.nav-link :active="request()->routeIs('public.product.index')">
                            <a href="{{ route('public.product.index') }}">Products</a>
                        </x-public.nav-link>


                        <li>
                            <a href="#" class="sf-with-ul">Tags</a>

                            <ul>
                                @foreach($this->tags as $tag)

                                <li><a href="{{ route('public.tag.products.index', $tag->slug) }}">{{ $tag->name }}</a>
                                </li>

                                @endforeach

                            </ul>
                        </li>
                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
            </div><!-- End .col-lg-9 -->
            <div class="header-right">
                <i class="la la-lightbulb-o"></i>
                <p>Clearance Up to 30% Off</span></p>
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->
