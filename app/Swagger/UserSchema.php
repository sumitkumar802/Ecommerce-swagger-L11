<?php
namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="User",
 *     required={"id", "name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-22T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-22T12:34:56Z")
 * )
 */
class UserSchema
{
}


?>