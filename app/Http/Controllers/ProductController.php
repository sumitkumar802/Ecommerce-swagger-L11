<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Cache;


class ProductController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/products",
 *     tags={"Products"},
 *     summary="Get list of products",
 *     security={{"BearerAuth": {}}}, 
 *     @OA\Response(
 *         response=200,
 *         description="A list of products",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
 *     ),
 *     @OA\Response(response=401, description="Unauthorized"),
 *     @OA\Response(response=500, description="Internal Server Error")
 * )
 */
    public function index()
    {
        // exit("pop2"); 10 minutes expire
        $products = Cache::remember('products', 600, function () {
            return ProductResource::collection(Product::paginate(10));
        });
        return $products;


    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Products"},
     *     security={{"BearerAuth": {}}},
     *     summary="Create a new product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response="201", description="Product created successfully"),
     *     @OA\Response(response="400", description="Invalid input")
     * )
     */
    public function store(ProductRequest $request)
    {
   
        $product = Product::create($request->validated());
        Cache::forget('products');
        return new ProductResource($product);
    }
    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Get a single product",
     *     tags={"Products"},
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the product",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */

    public function show(Product $product)
    {
        return new ProductResource($product);
    }
    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Update a product",
     *     tags={"Products"},
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        Cache::forget("product_{$id}");
        Cache::forget('products');
        return new ProductResource($product);
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Delete a product",
     *     tags={"Products"},
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully"
     *     ),
     *     @OA\Response(response=404, description="Product not found")
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Cache::forget("product_{$id}");
        Cache::forget('products');
        return response()->json(['message'=>'Product deleted Successfully'], 200);
    }
}
/**
 * @OA\Schema(
 *     schema="Product",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="price", type="number"),
 * )
 */