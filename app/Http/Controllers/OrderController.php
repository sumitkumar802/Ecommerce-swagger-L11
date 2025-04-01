<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Cache;


class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v2/orders",
     *     tags={"Orders"},
     *     summary="Get list of orders",
     *     security={{"BearerAuth": {}}}, 
     *     @OA\Response(
     *         response=200,
     *         description="A list of orders",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Order"))
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function index()
    {
        // exit("pop2"); 10 minutes expire
        $orders = Cache::remember('orders', 600, function () {
            return OrderResource::collection(Order::paginate(10));
        });
        return $orders;


    }

    /**
     * @OA\Post(
     *     path="/api/v2/orders",
     *     tags={"Orders"},
     *     security={{"BearerAuth": {}}},
     *     summary="Create a new Order",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(response="201", description="Order created successfully"),
     *     @OA\Response(response="400", description="Invalid input")
     * )
     */
    public function store(OrderRequest $request)
    {
        // exit("lolo");
   
        $order= Order::create($request->validated());
        Cache::forget('orders');
        return new OrderResource($order);
    }
    /**
     * @OA\Get(
     *     path="/api/v2/orders/{id}",
     *     summary="Get a single Order",
     *     tags={"Orders"},
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the Order",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(response=404, description="Order not found")
     * )
     */

    public function show(Order $order)
    {
        return new OrderResource($order);
    }
    /**
     * @OA\Put(
     *     path="/api/v2/orders/{id}",
     *     summary="Update a Order",
     *     tags={"Orders"},
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(response=404, description="Order not found")
     * )
     */

    public function update(OrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        Cache::forget("order_{$order->id}");
        Cache::forget('orders');
        return new OrderResource($order);
    }

    /**
     * @OA\Delete(
     *     path="/api/v2/orders/{id}",
     *     summary="Delete a Order",
     *     tags={"Orders"},
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order deleted successfully"
     *     ),
     *     @OA\Response(response=404, description="Order not found")
     * )
     */
    public function destroy(Order $order)
    {
        $order->delete();
        Cache::forget("order_{$order->id}");
        Cache::forget('orders');
        return response()->json(['message'=>'Order deleted Successfully'], 200);
    }
}
/**
 * @OA\Schema(
 *     schema="Order",
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="price", type="number"),
 * )
 */
