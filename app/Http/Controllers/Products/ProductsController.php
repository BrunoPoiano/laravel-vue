<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        "quantity" => 'required|integer|min:0'
        ]);

        $user = Auth::user();

        $product = Product::create([
        "user_id" => $user->id,
        ...$request->all()
        ]);

        return response()->json($product, 201);

    }

    public function edit(Request $request, $product)
    {
        $user = Auth::user();
        if($user->id !== $product->user_id)
     {       return response()->json(['message' => 'Unauthorized'], 403);}

        $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        "quantity" => 'required|integer|min:0'
        ]);

        $product->update($request->all());

        return response()->json($product, 200);

    }

    public function update(Request $request, $product)
    {
        $user = Auth::user();
        if($user->id !== $product->user_id)
     {       return response()->json(['message' => 'Unauthorized'], 403);}

        $request->validate([
        'name' => 'string|max:255',
        'description' => 'string',
        'price' => 'numeric|min:0',
        "quantity" => 'integer|min:0'
        ]);

        $product->update($request->all());

        return response()->json($product, 200);
    }

    public function destroy(Request $request, $product)
    {
        $user = Auth::user();
        if($user->id !== $product->user_id)
     {       return response()->json(['message' => 'Unauthorized'], 403);}

     $product->delete();
     return response()->json(['message' => 'Product deleted'], 200);
    }
}
