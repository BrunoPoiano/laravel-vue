<?php

namespace App\Http\Controllers\PalavrasApp;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PalavrasController extends Controller
{
    public function index()
    {
        return Inertia::render('Palavras/LayoutPalavras');
    }
}
