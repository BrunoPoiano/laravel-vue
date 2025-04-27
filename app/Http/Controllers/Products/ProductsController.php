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

/**
 * Controller for handling product-related HTTP requests.
 * Manages product CRUD operations and listing with authentication checks.
 */
class ProductsController extends Controller
{
    protected $productService;

    /**
     * Inject ProductService dependency for business logic handling
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display the main products page with filters and pagination.
     * Renders the dashboard view with products data using Inertia.
     *
     * @param Request $request Contains filter parameters
     * @return Response Inertia view with products data
     */
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

    /**
     * API endpoint for retrieving filtered product list.
     * Returns JSON formatted product data with pagination.
     *
     * @param Request $request Contains filter and pagination parameters
     * @return JsonResponse Products collection with pagination metadata
     */
    public function list(Request $request)
    {
        $filters = request()->only(['search', 'category', 'per_page', 'current_page']);

        $perPage = $filters['per_page']     ?? 10;
        $page    = $filters['current_page'] ?? 1;

        $products = $this->productService->getFilteredProducts($filters, $perPage, $page);

        return ProductResource::collection($products)->response()->getData(true);

    }

    /**
     * Create a new product.
     * Validates input and associates product with authenticated user.
     *
     * @param ProductRequest $request Validated product data
     * @return JsonResponse Created product data with 201 status
     */
    public function store(ProductRequest $request)
    {

        $product = $this->productService->store($request->validated());

        return response()->json($product, 201);
    }

    /**
     * Update an existing product.
     * Validates input and checks product ownership before update.
     *
     * @param ProductRequest $request Validated product data
     * @param Product $product The product to update
     * @return JsonResponse Updated product data or error response
     */
    public function edit(ProductRequest $request, Product $product)
    {
        $user = Auth::user();

        if (intval($user->id) !== intval($product->user_id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->productService->edit($product, $request->validated());

        return response()->json($product, 200);
    }

    /**
     * Delete a product.
     * Checks product ownership before deletion.
     *
     * @param Request $request
     * @param Product $product The product to delete
     * @return JsonResponse Success message or error response
     */
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
