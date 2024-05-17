<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Resources\Cars\CarsResource;
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
     *          description="OK"
     *      )
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
     * @OA\Response(
     *   response=200,
     *   description="OK"
     *   )
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
     * @OA\Response(
     *   response=200,
     *   description="OK"
     *   )
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
     * @OA\Response(
     *   response=200,
     *   description="OK"
     *   )
     * ),
     */
    public function destroy(Car $cars) : JsonResponse
    {
        $cars->deleted($cars);
        return response()->json(['message' => 'Succesfully destroyed'], 200);
    }
}
