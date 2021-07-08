<?php

namespace App\Http\Controllers\QuizApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuizAppController extends Controller
{
    public function index (){
        return Inertia::render('QuizApp/LayoutQuizApp');
    }
}
