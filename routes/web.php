<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;


// Landing
Volt::route('/', 'public.landing')->name('home')->lazy();


        // Order
Volt::route('/wishlist', 'user.shop.wishlist')->name('shop.wishlist.index');
Volt::route('/cart', 'user.shop.cart')->name('shop.cart.index');


        // Transaction
Volt::route('/checkout', 'user.shop.transaction.checkout')->name('shop.transaction.checkout');


        //Product 
Volt::route('/product/show', 'public.product.show')->name('public.product.show');
// Upper is for the time being



Volt::route('/product/show/{product:slug}', 'public.product.show')->name('public.products.show');
Volt::route('/product', 'public.product.index')->name('public.product.index');


        // Category
Volt::route('/category', 'public.category.index')->name('public.category.index');
// Temp
Volt::route('/category/product', 'public.category.product')->name('public.category.product.index');
// 
Volt::route('/category/product/{category:slug}', 'public.category.product')->name('public.category.products.index');


        // Category

// Temp
Volt::route('/tag/product', 'public.tag.product')->name('public.tag.product.index');

Volt::route('/tag/product/{tag:slug}', 'public.tag.product')->name('public.tag.products.index');


        // Supporting Pages
Volt::route('/about', 'public.pages.about')->name('public.pages.about');
Volt::route('/faq', 'public.pages.faq')->name('public.pages.faq');
Volt::route('/contact', 'public.pages.contact')->name('public.pages.contact');




Route::middleware(['guest'])->group(function () {
    require __DIR__ . '/auth.php';
});


// Route::middleware(['auth','roleOr:user,corporate'])->group(function () {
//     require __DIR__ . '/user.php';
// });

Route::middleware(['auth','role:admin'])->group(function () {
    require __DIR__ . '/admin.php';
});


