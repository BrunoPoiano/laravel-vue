<?php

use App\Http\Controllers\ShoppingCartApp\ShoppingCartController;
use Illuminate\Support\Facades\Route;

Route::get('index', [ShoppingCartController::class, 'index'])->name('index');
Route::get('shoppingcart', [ShoppingCartController::class, 'shoppingcart'])->name('shoppingcart');
Route::get('getprodutos', [ShoppingCartController::class, 'getprodutos'])->name('getprodutos');


Route::get('criariventario', [ShoppingCartController::class, 'criariventario'])->name('criariventario');
route::post('store',[ShoppingCartController::class, 'store'])->name('store');