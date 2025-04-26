<?php

use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('', [ProductsController::class, 'list'])->name('products.index');
        Route::post('', [ProductsController::class, 'store'])->name('products.store');
        Route::prefix('{product}')->group(function () {
            Route::put('', [ProductsController::class, 'edit'])->name('products.edit');
            Route::patch('', [ProductsController::class, 'update'])->name('products.update');
            Route::delete('', [ProductsController::class, 'destroy'])->name('products.destroy');
        });
    });
});

require __DIR__.'/auth.php';
