<?php

use App\Http\Controllers\ShoppingCartApp\ShoppingCartController;
use Illuminate\Support\Facades\Route;

Route::get('index', [ShoppingCartController::class, 'index'])->name('index');
Route::get('shoppingcart', [ShoppingCartController::class, 'shoppingcart'])->name('shoppingcart');
Route::get('getprodutos', [ShoppingCartController::class, 'getprodutos'])->name('getprodutos');


Route::get('criariventario', [ShoppingCartController::class, 'criariventario'])->name('criariventario');
route::post('store',[ShoppingCartController::class, 'store'])->name('store');


Route::get('getcarrinho', [ShoppingCartController::class, 'getcarrinho'])->name('getcarrinho');
Route::post('carrinho', [ShoppingCartController::class, 'carrinho'])->name('carrinho');
Route::get('getprodutoscarrinho', [ShoppingCartController::class, 'getprodutoscarrinho'])->name('getprodutoscarrinho');
Route::post('pagamento', [ShoppingCartController::class, 'pagamento'])->name('pagamento');
Route::post('update', [ShoppingCartController::class, 'update'])->name('update');
Route::post('apagar', [ShoppingCartController::class, 'apagar'])->name('apagar');
Route::post('removercarrinho', [ShoppingCartController::class, 'removercarrinho'])->name('removercarrinho');

