<?php
namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Product",
 *     title="Product Model",
 *     description="Product details",
 *     required={"name", "price", "stock"}
 * )
 */
class ProductSchema
{


    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     example="Smartphone"
     * )
     */
    private $name;

    /**
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     nullable=true,
     *     example="A great smartphone"
     * )
     */
    private $description;

    /**
     * @OA\Property(
     *     property="price",
     *     type="number",
     *     format="float",
     *     example=199.99
     * )
     */
    private $price;

    /**
     * @OA\Property(
     *     property="stock",
     *     type="integer",
     *     example=10
     * )
     */
    private $stock;

    /**
     * @OA\Property(
     *     property="image",
     *     type="string",
     *     nullable=true,
     *     example="https://example.com/image.jpg"
     * )
     */
    private $image;


}
