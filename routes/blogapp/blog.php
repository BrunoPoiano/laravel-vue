<?php

use App\Http\Controllers\BlogApp\BlogAppController;
use Illuminate\Support\Facades\Route;

Route::get('/index', [BlogAppController::class, 'index'])->name('index');
Route::get('/getSecao',[BlogAppController::class, 'getSecao'])->name('getSecao');

Route::post('/getConteudo',[BlogAppController::class, 'getConteudo'])->name('getConteudo');
Route::post('/store', [BlogAppController::class, 'store'])->name('store');
Route::post('/delete', [BlogAppController::class, 'delete'])->name('delete'); 
Route::post('/getTagsConteudo', [BlogAppController::class, 'getTagsConteudo'])->name('getTagsConteudo'); 