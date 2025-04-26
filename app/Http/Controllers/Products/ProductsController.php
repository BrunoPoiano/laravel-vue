<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Numeric;

class ProductsController extends Controller
{
    public function list(Request $request)
    {
        $user = Auth::user();

        $products = Product::where('user_id', $user->id);

        // filters
        $products = $products->where(function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('description', 'like', '%'.$request->search.'%');
        });

        $perPage = $request->per_page     ?? 10;
        $page    = $request->current_page ?? 1;

        $products = $products->paginate($perPage, ['*'], 'page', $page);

        return ProductResource::collection($products)->response()->getData(true);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            ...$validated,
        ]);

        return response()->json($product, 201);
    }

    public function edit(Request $request, Product $product)
    {
        $user = Auth::user();


        if (intval($user->id) !== intval($product->user_id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return response()->json($product, 200);
    }

    public function update(Request $request, Product $product)
    {
        $user = Auth::user();
        if ($user->id !== $product->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name'        => 'string|max:255',
            'description' => 'string',
            'price'       => 'numeric|min:0',
            'quantity'    => 'integer|min:0',
        ]);

        $product->update($validated);

        return response()->json($product, 200);
    }

    public function destroy(Request $request, Product $product)
    {
        $user = Auth::user();
        if ($user->id !== $product->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
