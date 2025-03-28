<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RestaurantsController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('restaurants', [RestaurantsController::class, 'index'])->name('restaurants');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    
    Route::redirect('admin_panel', 'admin_panel/tenant');
    Volt::route('admin_panel/tenant', 'admin_panel.tenant')->name('admin_panel.tenant');

    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Volt::route('restaurants', 'restaurants')->name('restaurants');
});

require __DIR__.'/auth.php';
