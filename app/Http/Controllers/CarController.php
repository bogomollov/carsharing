<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Support\Facades\Cache as Redis;
use App\Http\Requests\Car\StoreRequest;
use App\Http\Requests\Car\UpdateRequest;
use App\Http\Resources\Car\CarResource;

class CarController extends Controller
{
    /**
     * 
     * @OA\Get(
     *      path="/car",
     *      summary="Получить все ТС",
     *      description="Получить список ТС",
     *      tags={"Машины"},
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Car")
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
        $cache = Redis::get('car_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = CarResource::collection(Car::all());
            Redis::put('car_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     * 
     * @OA\Get(
     *      path="/car/{id}",
     *      summary="Получить ТС",
     *      description="Получает ТС по идентификатору и возвращает его",
     *      tags={"Машины"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Car")
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
     * )
     *
     */
    public function show(Car $id)
    {
        $cache = Redis::get($id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new CarResource($id);
            Redis::put($id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     * 
     * @OA\Post(
     *      path="/car/create",
     *      summary="Создать ТС",
     *      description="Создает новое ТС и возвращает ее",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="CarCreate",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarCreate")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="model_id",
     *          description="Идентификатор модели",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="0b4932f2-5c19-4de2-9ddc-17ce2375d164")
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Статус аренды",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="rented")
     *      ),
     *      @OA\Parameter(
     *          name="mileage",
     *          description="Пробег ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example="10383")
     *      ),
     *      @OA\Parameter(
     *          name="license_plate",
     *          description="Гос.номер ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="J949YJ 93")
     *      ),
     *      @OA\Parameter(
     *          name="year",
     *          description="Год производства ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example="2003")
     *      ),
     *      @OA\Parameter(
     *          name="location",
     *          description="Координаты текущего местоположения ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="-35.71 -45.96609")
     *      ),
     *      @OA\Parameter(
     *          name="price_minute",
     *          description="Минутная цена аренды",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example="2")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Car")
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
     *  ),
     */
    public function store(StoreRequest $request)
    {
        $c = Car::create($request->validated());
        return CarResource::make($c)->resolve();
    }

    /**
     * 
     * @OA\Put(
     *      path="/car/{id}/update",
     *      summary="Обновить ТС",
     *      description="Обновляет запись о ТС и возвращает ее",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="Car",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/Car")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Существующий идентификатор ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор ТС",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Parameter(
     *          name="model_id",
     *          description="Cчет по умолчанию",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="0b4932f2-5c19-4de2-9ddc-17ce2375d164")
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Статус аренды",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="rented")
     *      ),
     *      @OA\Parameter(
     *          name="mileage",
     *          description="Пробег ТС",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="integer", example="10383")
     *      ),
     *      @OA\Parameter(
     *          name="license_plate",
     *          description="Гос.номер ТС",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="Н709ОM 147")
     *      ),
     *      @OA\Parameter(
     *          name="year",
     *          description="Год производства ТС",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="integer", example="2003")
     *      ),
     *      @OA\Parameter(
     *          name="location",
     *          description="Координаты текущего местоположения ТС",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="-35.71 -45.96609")
     *      ),
     *      @OA\Parameter(
     *          name="price_minute",
     *          description="Минутная цена аренды",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="integer", example="2")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Car")
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
    public function update(UpdateRequest $request, Car $id)
    {
        $id->update($request->validated());
        return new CarResource($id);
    }

    /**
     * 
     * @OA\Delete(
     *      path="/car/{id}/delete",
     *      summary="Удалить ТС",
     *      description="Удаляет запись о ТС",
     *      tags={"Машины"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Car")
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
    public function destroy(Car $id)
    {
        $id->delete();
        return new CarResource($id);
    }
}
