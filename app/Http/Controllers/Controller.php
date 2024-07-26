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
 * ),
 * @OA\Schema(
 *  schema="ArendatorAll",
 *  title="ArendatorAll",
 *   @OA\Property(property="data", type="array",
 *       @OA\Items(
 *          @OA\Property(property="id", type="uuid", example="af42801a-70bb-4966-87d6-d53ead3015b5"),
 *          @OA\Property(property="default_bill_id", type="uuid", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b"),
 *          @OA\Property(property="last_name", type="string", example="Haley"),
 *          @OA\Property(property="first_name", type="string", example="Carolyn"),
 *          @OA\Property(property="middle_name", type="string", example="Berta"),
 *          @OA\Property(property="status", type="string", example="active"),
 *          @OA\Property(property="phone", type="integer", example="7525301782"),
 *       ),
 *   ),
 * ),
 * @OA\Schema(
 *  schema="ArendatorId",
 *  title="ArendatorId",
 *  type="object",
 *  @OA\Property(property="data",type="object",
 *      @OA\Property(property="id", type="uuid", example="af42801a-70bb-4966-87d6-d53ead3015b5"),
 *      @OA\Property(property="default_bill_id", type="uuid", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b"),
 *      @OA\Property(property="last_name", type="string", example="Haley"),
 *      @OA\Property(property="first_name", type="string", example="Carolyn"),
 *      @OA\Property(property="middle_name", type="string", example="Berta"),
 *      @OA\Property(property="status", type="string", example="active"),
 *      @OA\Property(property="phone", type="integer", example="7525301782"),
 *  ),
 * ),
 * @OA\Schema(
 *  schema="ArendatorRequest",
 *  title="ArendatorRequest",
 *      @OA\Property(property="id", type="uuid", example="af42801a-70bb-4966-87d6-d53ead3015b5"),
 *      @OA\Property(property="default_bill_id", type="uuid", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b"),
 *      @OA\Property(property="last_name", type="string", example="Haley"),
 *      @OA\Property(property="first_name", type="string", example="Carolyn"),
 *      @OA\Property(property="middle_name", type="string", example="Berta"),
 *      @OA\Property(property="status", type="string", example="active"),
 *      @OA\Property(property="passport_series", type="string", example="52 59"),
 *      @OA\Property(property="passport_number", type="string", example="875660"),
 *      @OA\Property(property="phone", type="integer", example="7525301782"),
 *  ),
 * ),
 * @OA\Schema(
 *  schema="ArendatorChange",
 *  title="ArendatorChange",
 *  type="object",
 *  @OA\Property(property="data",type="object",
 *      @OA\Property(property="id", type="uuid", example="af42801a-70bb-4966-87d6-d53ead3015b5"),
 *      @OA\Property(property="default_bill_id", type="uuid", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b"),
 *      @OA\Property(property="last_name", type="string", example="Haley"),
 *      @OA\Property(property="first_name", type="string", example="Carolyn"),
 *      @OA\Property(property="middle_name", type="string", example="Berta"),
 *      @OA\Property(property="status", type="string", example="active"),
 *      @OA\Property(property="passport_series", type="string", example="52 59"),
 *      @OA\Property(property="passport_number", type="string", example="875660"),
 *      @OA\Property(property="phone", type="integer", example="7525301782"),
 *  ),
 * ),
 * @OA\Schema(
 *  schema="ArendatorDefaultBill",
 *  title="ArendatorDefaultBill",
 *      @OA\Property(property="default_bill_id", type="uuid", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b"),
 * ),
 * @OA\Schema(
 *  schema="ArendatorStatus",
 *  title="ArendatorStatus",
 *      @OA\Property(property="status", type="string", example="frozen"),
 * ),
 * @OA\Schema(
 *  schema="BillAll",
 *  title="BillAll",
 *   @OA\Property(property="data", type="array",
 *       @OA\Items(
 *          @OA\Property(property="id", type="uuid", example="ff7f36b1-1cab-35b9-9b3f-969bb0e92109"),
 *          @OA\Property(property="arendators_count", type="integer", example=1),
 *          @OA\Property(property="type", type="string", example="personal"),
 *          @OA\Property(property="status", type="string", example="open"),
 *       ),
 *   ),
 * ),
 * @OA\Schema(
 *  schema="BillId",
 *  title="BillId",
 *  type="object",
 *  @OA\Property(property="data",type="object",
 *      @OA\Property(property="id", type="uuid", example="ff7f36b1-1cab-35b9-9b3f-969bb0e92109"),
 *      @OA\Property(property="arendators_count", type="integer", example=1),
 *      @OA\Property(property="type", type="string", example="personal"),
 *      @OA\Property(property="status", type="string", example="open"),
 *   ),
 * ),
 * @OA\Schema(
 *  schema="BillRequest",
 *  title="BillRequest",
 *      @OA\Property(property="arendators_count", type="integer", example=1),
 *      @OA\Property(property="balance", type="decimal", example=48658.52),
 *      @OA\Property(property="type", type="string", example="personal"),
 *      @OA\Property(property="status", type="string", example="open"),
 *  ),
 * ),
 * @OA\Schema(
 *  schema="BillChange",
 *  title="BillChange",
 *  type="object",
 *  @OA\Property(property="data",type="object",
 *      @OA\Property(property="id", type="uuid", example="ff7f36b1-1cab-35b9-9b3f-969bb0e92109"),
 *      @OA\Property(property="arendators_count", type="integer", example=1),
 *      @OA\Property(property="balance", type="decimal", example=48658.52),
 *      @OA\Property(property="type", type="string", example="personal"),
 *      @OA\Property(property="status", type="string", example="open"),
 *      ),
 * ),
 * @OA\Schema(
 *  schema="BillStatus",
 *  title="BillStatus",
 *      @OA\Property(property="status", type="string", example="closed"),
 * ),
 * @OA\Schema(
 *  schema="CarAll",
 *  title="CarAll",
 *   @OA\Property(property="data", type="array",
 *       @OA\Items(
 *          @OA\Property(property="id", type="uuid", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3"),
 *          @OA\Property(property="model_id", type="uuid", example="0b4932f2-5c19-4de2-9ddc-17ce2375d164"),
 *          @OA\Property(property="status", type="string", example="rented"),
 *          @OA\Property(property="mileage", type="integer", example=10383),
 *          @OA\Property(property="license_plate", type="string", example="J949YJ 93"),
 *          @OA\Property(property="year", type="integer", example=2003),
 *          @OA\Property(property="price_minute", type="integer", example=2),
 *       ),
 *   ),
 * ),
 * @OA\Schema(
 *  schema="CarId",
 *  title="CarId",
 *  type="object",
 *  @OA\Property(property="data",type="object",
 *      @OA\Property(property="id", type="uuid", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3"),
 *      @OA\Property(property="model_id", type="uuid", example="0b4932f2-5c19-4de2-9ddc-17ce2375d164"),
 *      @OA\Property(property="status", type="string", example="rented"),
 *      @OA\Property(property="mileage", type="integer", example=10383),
 *      @OA\Property(property="license_plate", type="string", example="J949YJ 93"),
 *      @OA\Property(property="year", type="integer", example=2003),
 *      @OA\Property(property="price_minute", type="integer", example=2),
 *     ),
 * ),
 * @OA\Schema(
 *  schema="CarRequest",
 *  title="CarRequest",
 *      @OA\Property(property="model_id", type="uuid", example="0b4932f2-5c19-4de2-9ddc-17ce2375d164"),
 *      @OA\Property(property="status", type="string", example="rented"),
 *      @OA\Property(property="mileage", type="integer", example=10383),
 *      @OA\Property(property="license_plate", type="string", example="J949YJ 93"),
 *      @OA\Property(property="year", type="integer", example=2003),
 *      @OA\Property(property="location", type="string", example="-35.71 -45.96609"),
 *      @OA\Property(property="price_minute", type="integer", example=2),
 * ),
 * @OA\Schema(
 *  schema="CarChange",
 *  title="CarChange",
 *  type="object",
 *  @OA\Property(property="data",type="object",
 *      @OA\Property(property="model_id", type="uuid", example="0b4932f2-5c19-4de2-9ddc-17ce2375d164"),
 *      @OA\Property(property="status", type="string", example="rented"),
 *      @OA\Property(property="mileage", type="integer", example=10383),
 *      @OA\Property(property="license_plate", type="string", example="J949YJ 93"),
 *      @OA\Property(property="year", type="integer", example=2003),
 *      @OA\Property(property="location", type="string", example="-35.71 -45.96609"),
 *      @OA\Property(property="price_minute", type="integer", example=2),
 *      ),
 * ),
 * @OA\Schema(
 *  schema="CarStatus",
 *  title="CarStatus",
 *      @OA\Property(property="status", type="string", example="expectation"),
 * ),
 * @OA\Schema(
 *  schema="CarManufacturerAll",
 *  title="CarManufacturerAll",
 *   @OA\Property(property="data", type="array",
 *       @OA\Items(
 *          @OA\Property(property="id", type="uuid", example="24a0f5c9-0a83-4b79-8bb2-173fa979749b"),
 *          @OA\Property(property="name", type="string", example="General Motors"),
 *       ),
 *    ),
 * ),
 * @OA\Schema(
 *  schema="CarManufacturerId",
 *  title="CarManufacturerId",
 *  type="object",
 *  @OA\Property(property="data",type="object",
 *      @OA\Property(property="id", type="uuid", example="24a0f5c9-0a83-4b79-8bb2-173fa979749b"),
 *      @OA\Property(property="name", type="string", example="General Motors"),
 *      ),
 * ),
 * @OA\Schema(
 *  schema="CarModel",
 *  title="CarModel",
 *      @OA\Property(property="id", type="uuid", example="beceda62-2656-3617-97b9-b686a7d36e3b"),
 *      @OA\Property(property="mark_id", type="uuid", example="81591380-f082-4657-b737-9cf8e25fa48a"),
 *      @OA\Property(property="name", type="string", example="911"),
 * ),
 * @OA\Schema(
 *  schema="CarMark",
 *  title="CarMark",
 *      @OA\Property(property="id", type="uuid", example="09d92bd9-c054-4495-83cb-3c9bb5ea4c57"),
 *      @OA\Property(property="manufacturer_id", type="uuid", example="a26c1313-c227-4a81-97fa-6f978b5c4996"),
 *      @OA\Property(property="name", type="string", example="Porsche"),
 * ),
 * @OA\Schema(
 *  schema="Rent",
 *  title="Rent",
 *      @OA\Property(property="id", type="uuid", example="beceda62-2656-3617-97b9-b686a7d36e3b"),
 *      @OA\Property(property="car_id", type="uuid", example="40644966-2862-35d0-a7c6-ad87c512625a"),
 *      @OA\Property(property="arendator_id", type="uuid", example="63f081c5-1967-322f-9c2a-7f7b116441fc"),
 *      @OA\Property(property="status", type="string", example="open"),
 *      @OA\Property(property="start_datetime", type="string", example="2024-07-06 19:52:25"),
 *      @OA\Property(property="end_datetime", type="string", example="2024-07-06 19:52:25"),
 *      @OA\Property(property="rented_time", type="integer", example=720),
 *      @OA\Property(property="total_price", type="decimal", example=8658.32),
 * ),
 * @OA\Schema(
 *  schema="RentOpen",
 *  title="RentOpen",
 *      @OA\Property(property="car_id", type="uuid", example="40644966-2862-35d0-a7c6-ad87c512625a"),
 *      @OA\Property(property="arendator_id", type="uuid", example="63f081c5-1967-322f-9c2a-7f7b116441fc"),
 * ),
 * @OA\Schema(
 *  schema="RentClose",
 *  title="RentClose",
 *      @OA\Property(property="id", type="uuid", example="40644966-2862-35d0-a7c6-ad87c512625a"),
 * ),
 * @OA\Schema(
 *  schema="Transaction",
 *  title="Transaction",
 *      @OA\Property(property="id", type="uuid", example="c62bf9d4-865f-49da-ba56-ab4fa7528698"),
 *      @OA\Property(property="arendator_id", type="uuid", example="ae05a42b-9464-43df-83ed-dea6acf36f41"),
 *      @OA\Property(property="bill_id", type="uuid", example="4d380caf-18a7-31e8-93ed-e5d2b5d93251"),
 *      @OA\Property(property="modification", type="decimal", example=200.22),
 * ),
 * @OA\Schema(
 *  schema="TransactionCreate",
 *  title="TransactionCreate",
 *      @OA\Property(property="arendator_id", type="uuid", example="ae05a42b-9464-43df-83ed-dea6acf36f41"),
 *      @OA\Property(property="bill_id", type="uuid", example="4d380caf-18a7-31e8-93ed-e5d2b5d93251"),
 *      @OA\Property(property="modification", type="decimal", example=200.22),
 * ),
 * @OA\Schema(
 *  schema="Response401",
 *  title="Response401",
 *      @OA\Property(
 *          property="status",
 *          type="integer",
 *          example="401"
 *      ),
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
 *          property="status",
 *          type="integer",
 *          example="403"
 *      ),
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
 *          property="status",
 *          type="integer",
 *          example="404"
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="Not Found"
 *    )
 * ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
