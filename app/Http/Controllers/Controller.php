<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5Swagger",
 *      description="Implementation of Swagger with in Laravel",
 *      @OA\Contact(
 *          email="admin@admin.com"         
 *      ), 
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * 
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Local"
 * )
 * 
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST2,
 *      description="Production"
 * )
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\Schema(
 *  schema="User",
 *  title="User",
 *      @OA\Property(property="id", type="string", example="45c746aa-64e1-349c-8a94-9daf95d36c52"),
 *      @OA\Property(property="default_bill_id", type="string", example=1),
 *      @OA\Property(property="last_name", type="string", example="Haley"),
 *      @OA\Property(property="first_name", type="string", example="Carolyn"),
 *      @OA\Property(property="middle_name", type="string", example="Berta"),
 *      @OA\Property(property="status", type="string", example="active"),
 *      @OA\Property(property="created_at", type="string", example="2024-05-17T13:22:34.000000Z"),
 *      @OA\Property(property="updated_at", type="string", example="2024-05-17T13:22:34.000000Z"),
 *      @OA\Property(property="deleted_at", type="string", example=null),
 * ),
 * @OA\Schema(
 *  schema="Car",
 *  title="Car",
 *      @OA\Property(property="id", type="string", example="5034b4cc-0852-3b32-b7f6-0eb8e438d76d"),
 *      @OA\Property(property="model_id", type="string", example="99447261-3369-4f90-abcd-f126664874d8"),
 *      @OA\Property(property="status", type="string", example="rented"),
 *      @OA\Property(property="mileage", type="integer", example=10383),
 *      @OA\Property(property="license_plate", type="string", example="Н709ОM 147"),
 *      @OA\Property(property="year", type="integer", example=2003),
 *      @OA\Property(property="location", type="string", example="-35.71 -45.96609"),
 *      @OA\Property(property="price_minute", type="integer", example=2),
 *      @OA\Property(property="created_at", type="string", example="2024-05-17T13:22:34.000000Z"),
 *      @OA\Property(property="updated_at", type="string", example="2024-05-17T13:22:34.000000Z"),
 *      @OA\Property(property="deleted_at", type="string", example=null),
 * ),
 * @OA\Schema(
 *  schema="Response401",
 *  title="Response401",
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="Unauthorized"
 *    )
 * ),
 * @OA\Schema(
 *  schema="Response403",
 *  title="Response403",
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="Forbidden"
 *    )
 * ),
 * @OA\Schema(
 *  schema="Response404",
 *  title="Response404",
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="Not Found"
 *    )
 * ) 
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
