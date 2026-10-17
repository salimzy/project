<?php

use App\Http\Controllers\MarketplaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MarketplaceController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('gigs/create', [MarketplaceController::class, 'create'])->name('gigs.create');
    Route::post('gigs', [MarketplaceController::class, 'store'])->name('gigs.store');
    Route::get('gigs/{gig}/edit', [MarketplaceController::class, 'edit'])->name('gigs.edit');
    Route::put('gigs/{gig}', [MarketplaceController::class, 'update'])->name('gigs.update');
});

Route::get('gigs/{gig:slug}', [MarketplaceController::class, 'show'])->name('gigs.show');

require __DIR__.'/settings.php';
