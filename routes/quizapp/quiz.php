<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizApp\QuizAppController;

Route::get('index',[QuizAppController::class, 'index'])->name('index');