<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;


// Landing
Volt::route('/', 'public.landing')->name('public.landing')->lazy();


//  'verified', 
// Dashboard
Route::middleware(['auth','role:admin'])->group(function () {
    require __DIR__ . '/admin.php';
});

Route::middleware(['guest'])->group(function () {
    require __DIR__ . '/auth.php';
});
