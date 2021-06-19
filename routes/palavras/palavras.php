<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PalavrasApp\PalavrasController;

Route::get('index', [PalavrasController::class,'index'])->name('index');
