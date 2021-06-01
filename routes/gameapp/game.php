<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameApp\GameAppController;

Route::get('/index', [GameAppController::class, 'index'])->name('index');
