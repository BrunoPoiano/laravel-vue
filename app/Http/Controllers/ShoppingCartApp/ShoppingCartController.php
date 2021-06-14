<?php

namespace App\Http\Controllers\ShoppingCartApp;

use App\Http\Controllers\Controller;
use App\Models\ShoppingCart\ProdutoSc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShoppingCartController extends Controller
{
    
    ////////////////index///////////////////////////////////////
    public function index(){
        return Inertia::render('ShoppingCartApp/Index/LayoutShoppingCart');
    }

    public function getprodutos(){
        return ProdutoSc::orderby('created_at','asc')->get();
    }

    /////////////////////////////// CRIAR INVENTARIO ////////////////

    public function criariventario(){
        return Inertia::render('ShoppingCartApp/CriarInventario/CriarInventario');
    }

    public function store(Request $request){
        if($request){
            $produto = new ProdutoSc([
                'user_id'=> Auth::id(),
                'nome' => $request->nome,
                'descricao'=> $request->descricao,
                'quantidade'=> $request->quantidade,
                'preco'=> $request->preco,
            ]);
            $produto->save();
            return true;
        }
        return false;
    }
}
