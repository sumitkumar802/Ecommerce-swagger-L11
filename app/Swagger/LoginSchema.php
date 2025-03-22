<?php
namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="Login",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="secret123")
 * )
 */
class LoginSchema
{
}



?>