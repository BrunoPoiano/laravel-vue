<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

//Direcionar para TodoApp
Route::prefix('/todo')->middleware(['auth:sanctum', 'verified'])->name('todo.layout.')->group(base_path('routes/todoapp/todo.php'));

//Direcionar para Jogo do tempo
Route::prefix('/game')->middleware(['auth:sanctum', 'verified'])->name('game.layout.')->group(base_path('routes/gameapp/game.php'));

//Direcionar para Blog
Route::prefix('/blog')->middleware(['auth:sanctum', 'verified'])->name('blog.layout.')->group(base_path('routes/blogapp/blog.php'));

//Direcionar ShoopingCart
Route::prefix('/shoppingcart')->middleware(['auth:sanctum', 'verified'])->name('shoppingcart.layout.')->group(base_path('routes/shoppingcartapp/shoppingcart.php'));

//Direcionar jogos de palavras
Route::prefix('/palavras')->middleware(['auth:sanctum', 'verified'])->name('palavras.layout.')->group(base_path('routes/palavras/palavras.php'));

//Direcionar Quiz app
Route::prefix('/quiz')->middleware(['auth:sanctum', 'verified'])->name('quiz.layout.')->group(base_path('routes/quizapp/quiz.php'));
