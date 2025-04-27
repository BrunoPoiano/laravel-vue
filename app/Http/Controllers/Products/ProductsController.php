<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductsController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $filters = request()->only(['search', 'per_page', 'current_page']);

        $perPage = $filters['per_page']     ?? 10;
        $page    = $filters['current_page'] ?? 1;

        $products = $this->productService->getFilteredProducts($filters, $perPage, $page);

        return Inertia::render('Dashboard/Index', [
            'products'   => ProductResource::collection($products),
            'filters'    => $filters,
            'pagination' => new PaginationResource($products),
        ]);
    }

    public function list(Request $request)
    {
        $filters = request()->only(['search', 'category', 'per_page', 'current_page']);

        $perPage = $filters['per_page']     ?? 10;
        $page    = $filters['current_page'] ?? 1;

        $products = $this->productService->getFilteredProducts($filters, $perPage, $page);

        return ProductResource::collection($products)->response()->getData(true);

    }

    public function store(ProductRequest $request)
    {

        $product = $this->productService->store($request->validated());

        return response()->json($product, 201);
    }

    public function edit(ProductRequest $request, Product $product)
    {
        $user = Auth::user();

        if (intval($user->id) !== intval($product->user_id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->productService->edit($product, $request->validated());

        return response()->json($product, 200);
    }

    public function destroy(Request $request, Product $product)
    {
        $user = Auth::user();
        if ($user->id !== $product->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->productService->destroy($product);

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
