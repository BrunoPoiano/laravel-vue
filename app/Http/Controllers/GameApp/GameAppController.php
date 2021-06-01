<?php

namespace App\Http\Controllers\GameApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameAppController extends Controller
{
    public function index(){
        return Inertia::render('GameApp/LayoutGameApp');

    }
}
