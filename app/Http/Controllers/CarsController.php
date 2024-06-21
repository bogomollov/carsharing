<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Cars\StoreRequest;
use App\Http\Requests\Cars\UpdateRequest;
use Illuminate\Http\JsonResponse;

class CarsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/cars",
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
    public function index() : JsonResponse
    {
        return response()->json(Car::all());
    }

    /**
     * @OA\Get(
     *      path="/cars/{id}",
     *      summary="Получить ТС",
     *      description="Получает ТС по идентификатору и возвращает его",
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
     * )
     *
     */
    public function show(int $id) : JsonResponse
    {
        $cars = Car::find($id);
        return response()->json([
            $cars->id => $cars
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/cars/create",
     *      summary="Создать ТС",
     *      description="Создает новое ТС и возвращает ее",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="PostUser",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/Car")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="model_id",
     *          description="Cчет по умолчанию",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="99447261-3369-4f90-abcd-f126664874d8")
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
     *          @OA\Schema(type="string", example="Н709ОM 147")
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
     *      @OA\Parameter(
     *          name="created_at",
     *          description="Дата создания записи",
     *          required=false,
     *          in="path",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="updated_at",
     *          description="Дата обновления записи",
     *          required=false,
     *          in="path",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="deleted_at",
     *          description="Дата удаления записи",
     *          required=false,
     *          in="path",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
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
    public function store(StoreRequest $request) : JsonResponse
    {
        $cars = Car::create($request->validated());

        return response()->json([
            'message' => 'Succesfully created',
            $cars->id => $cars
        ], 200);
    }

    /**
     * @OA\Patch(
     *      path="/cars/{id}/update",
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
     *          description="Идентификатор ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="model_id",
     *          description="Cчет по умолчанию",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="99447261-3369-4f90-abcd-f126664874d8")
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
     *          @OA\Schema(type="string", example="Н709ОM 147")
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
     *      @OA\Parameter(
     *          name="created_at",
     *          description="Дата создания записи",
     *          required=false,
     *          in="path",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="updated_at",
     *          description="Дата обновления записи",
     *          required=false,
     *          in="path",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="deleted_at",
     *          description="Дата удаления записи",
     *          required=false,
     *          in="path",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
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
    public function update(UpdateRequest $request, Car $cars) : JsonResponse
    {
        $cars->update($request->validated());

        return response()->json([
            'message' => 'Succesfully updated',
            $cars->id => $cars
        ], 200);

    }

    /**
     * @OA\Delete(
     *      path="/cars/{id}/delete",
     *      summary="Удалить ТС",
     *      description="Удаляет запись о ТС",
     *      tags={"Машины"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
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
    public function destroy(Car $cars) : JsonResponse
    {
        $cars->deleted($cars);
        return response()->json(['message' => 'Succesfully destroyed'], 200);
    }
}
