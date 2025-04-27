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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('', [ProductsController::class, 'index'])->name('products.index');
        Route::get('list', [ProductsController::class, 'list'])->name('products.list');
        Route::post('', [ProductsController::class, 'store'])->name('products.store');
        Route::prefix('{product}')->group(function () {
            Route::put('', [ProductsController::class, 'edit'])->name('products.edit');
            Route::delete('', [ProductsController::class, 'destroy'])->name('products.destroy');
        });
    });
});

require __DIR__.'/auth.php';
