<?php

use App\Models\Service;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

// Route::view( 'profile', 'profile' )
// ->name( 'profile' );

// Home
Volt::route( 'dashboard', 'admin.dashboard' )->name( 'dashboard' );

// Profile
Volt::route( 'profile', 'admin.account.profile' )->name( 'profile' );

// Customer
Volt::route( '/admin/user/create', 'admin.user.create' )->name( 'admin.user.create' );
Volt::route( '/admin/user', 'admin.user.index' )->name( 'admin.user.index' );
Volt::route( '/admin/user/{user:uuid}/edit', 'admin.user.edit' )->name( 'admin.user.edit' );


// Store
    // Category
Volt::route( '/admin/store/category/create', 'admin.store.category.create' )->name( 'admin.store.category.create' );
Volt::route( '/admin/store/category', 'admin.store.category.index' )->name( 'admin.store.category.index' );
Volt::route( '/admin/store/category/{category:uuid}/edit', 'admin.store.category.edit' )->name( 'admin.store.category.edit' );

    // Tag
Volt::route( '/admin/store/tag/create', 'admin.store.tag.create' )->name( 'admin.store.tag.create' );
Volt::route( '/admin/store/tag', 'admin.store.tag.index' )->name( 'admin.store.tag.index' );
Volt::route( '/admin/store/tag/{tag:uuid}/edit', 'admin.store.tag.edit' )->name( 'admin.store.tag.edit' );

    // Template
Volt::route( '/admin/store/template/create', 'admin.store.template.create' )->name( 'admin.store.template.create' );
Volt::route( '/admin/store/template', 'admin.store.template.index' )->name( 'admin.store.template.index' );
Volt::route( '/admin/store/template/{template:uuid}/edit', 'admin.store.template.edit' )->name( 'admin.store.template.edit' );


    // Product
Volt::route( '/admin/store/product/create', 'admin.store.product.create' )->name( 'admin.store.product.create' );
Volt::route( '/admin/store/product', 'admin.store.product.index' )->name( 'admin.store.product.index' );
Volt::route( '/admin/store/product/{product:uuid}/edit', 'admin.store.product.edit' )->name( 'admin.store.product.edit' );
Volt::route( '/admin/store/product/{product:uuid}/template', 'admin.store.product.template' )->name( 'admin.store.product.template' );
Volt::route( '/admin/store/product/{product:uuid}/template/edit', 'admin.store.product.edittemplate' )->name( 'admin.store.product.template.edit' );

// admin.store.product.template.edit



// Settings
    // Social Media
Volt::route( '/admin/setting/socialmedia/edit', 'admin.setting.socialmedia.edit' )->name( 'admin.setting.socialmedia.edit' );

    // Coupon 
Volt::route( '/admin/setting/coupon/create', 'admin.setting.coupon.create' )->name( 'admin.setting.coupon.create' );
Volt::route( '/admin/setting/coupon', 'admin.setting.coupon.index' )->name( 'admin.setting.coupon.index' );
Volt::route( '/admin/setting/coupon/{coupon:uuid}/edit', 'admin.setting.coupon.edit' )->name( 'admin.setting.coupon.edit' );


    // Payment methods
Volt::route( '/admin/setting/payment/create', 'admin.setting.payment.create' )->name( 'admin.setting.payment.create' );
Volt::route( '/admin/setting/payment', 'admin.setting.payment.index' )->name( 'admin.setting.payment.index' );
Volt::route( '/admin/setting/payment/{payment:uuid}/edit', 'admin.setting.payment.edit' )->name( 'admin.setting.payment.edit' );

    // Couriers
Volt::route( '/admin/setting/courier/create', 'admin.setting.courier.create' )->name( 'admin.setting.courier.create' );
Volt::route( '/admin/setting/courier', 'admin.setting.courier.index' )->name( 'admin.setting.courier.index' );
Volt::route( '/admin/setting/courier/{courier:uuid}/edit', 'admin.setting.courier.edit' )->name( 'admin.setting.courier.edit' );



// Orders
Volt::route( '/admin/order/create', 'admin.order.create' )->name( 'admin.order.create' );
Volt::route( '/admin/order', 'admin.order.index' )->name( 'admin.order.index' );
Volt::route( '/admin/order/{order:uuid}/edit', 'admin.order.edit' )->name( 'admin.order.edit' );
// admin.order.index

// Transactions
Volt::route( '/admin/transaction', 'admin.transaction.index' )->name( 'admin.transaction.index' );

