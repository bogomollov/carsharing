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
     *      path="/api/cars/",
     *      summary="Получить все ТС",
     *      description="Получить список ТС",
     *      tags={"Машины"},
     * @OA\Response(
     *   response=200,
     *   description="OK"
     *   )
     * ),
     */    
    public function index() : JsonResponse
    {
        return response()->json(Car::all());
    }

    public function create()
    {
        
    }
    /**
     * @OA\Post(
     *      path="/api/cars/",
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
     * @OA\Get(
     *      path="/api/cars/{id}",
     *      summary="Получить ТС",
     *      description="Получает ТС по идентификатору и возвращает его",
     *      tags={"Машины"},
     * @OA\Response(
     *   response=200,
     *   description="OK"
     *   )
     * ),
     */
    public function show(int $id) : JsonResponse
    {
        $cars = Car::find($id);
        return response()->json([
            $cars->id => $cars
        ], 200);
    }

    public function edit(Car $cars)
    {
        //
    }

    /**
     * @OA\Patch(
     *      path="/api/cars/{id}",
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
     *      path="/api/cars/{id}",
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
