<?php
namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="User",
 *     required={"name", "email","password","password_confirmation"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="secret123"),
 *     @OA\Property(property="password_confirmation", type="string", format="password", example="secret123")
 * )
 */
class UserSchema
{
}

?>