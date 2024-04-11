<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Jobs\SendNotificationJob;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    protected $productService;

    protected $product;

    protected $per_page;

    public function __construct(Product $product, ProductService $productService)
    {
        $this->product = $product;
        $this->productService = $productService;
        $this->per_page = request('per_page', 20);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product;

        $products = $products->filter()->paginate($this->per_page);

        return response()->json([
            'result' => [
                'data' => new ProductCollection($products)
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = $this->productService->create($request->all());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        SendNotificationJob::dispatch($product);

        return response()->json([
            'status' => true,
            'message' =>'Product created successfully!'
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'result' => [
                'data' => [
                    'product' => new ProductResource($product)
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $allowedColumns = $this->productService->allowedColumnsForUpdate();
            $data = $request->only($allowedColumns);

            $product->update($data);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return response()->json([
            'status' => true,
            'message' => 'Product update successfully!'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully!'
        ]);
    }
}
