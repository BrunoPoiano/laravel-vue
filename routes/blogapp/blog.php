<?php

use App\Http\Controllers\BlogApp\BlogAppController;
use Illuminate\Support\Facades\Route;

//Route::get('/secao', [App\Http\Controllers\BlogApp\BlogAppController::class, 'secao']);

Route::get('/index', [BlogAppController::class, 'index'])->name('index');
Route::get('/getSecao',[BlogAppController::class, 'getSecao'])->name('getSecao');

Route::post('/getConteudo',[BlogAppController::class, 'getConteudo'])->name('getConteudo');
Route::post('/store', [BlogAppController::class, 'store'])->name('store');
Route::post('/delete', [BlogAppController::class, 'delete'])->name('delete'); 
Route::post('/getTagsConteudo', [BlogAppController::class, 'getTagsConteudo'])->name('getTagsConteudo'); 

///////////////////////////PAGINA//////////////////////////

Route::get('/pagina/{id}', [BlogAppController::class, 'pagina'])->name('pagina'); 
Route::post('/getContentbyId', [BlogAppController::class, 'getContentbyId'])->name('getContentbyId'); 