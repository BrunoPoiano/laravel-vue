<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoApp\TodoAppController;

Route::get('/index', [TodoAppController::class, 'index'])->name('index');
Route::get('/getAfazeres', [TodoAppController::class, 'getAfazeres'])->name('getAfazeres');

Route::post('/store', [TodoAppController::class, 'store'])->name('store');
Route::post('/update', [TodoAppController::class, 'update'])->name('update');
Route::post('/delete', [TodoAppController::class, 'delete'])->name('delete');
