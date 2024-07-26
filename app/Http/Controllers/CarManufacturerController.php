<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarManufacturer\CarManufacturerResource;
use App\Models\CarManufacturer;
use Illuminate\Support\Facades\Cache as Redis;

class CarManufacturerController extends Controller
{
    /**
     * 
     * @OA\Get(
     *      path="/car_manufacturer",
     *      summary="Получить всех производителей ТС",
     *      description="Получить список производителей ТС",
     *      tags={"Машины"},
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarManufacturerAll")
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Не авторизован",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Response401")
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Доступ запрещен",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Response403")
     *              }
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найдено",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Response404")
     *              }
     *          )
     *      ),
     * ),
     */
    public function index()
    {
        $cache = Redis::get('car_manufacturer_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = CarManufacturerResource::collection(CarManufacturer::all());
            Redis::put('car_manufacturer_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }
}
