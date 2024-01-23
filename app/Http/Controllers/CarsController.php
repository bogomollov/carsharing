<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use Illuminate\Http\Request;
use App\Http\Resources\Cars\CarsResource;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Cars\StoreRequest;
use App\Http\Requests\Cars\UpdateRequest;
use Illuminate\Http\JsonResponse;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *      path="/api/cars/",
     *      summary="Получить все ТС",
     *      description="Получить список ТС",
     *      tags={"Машины"},
     *      @OA\Response(
     *          response="200",
     *          description="Возвращает список ТС",
     *      )
     * ),
     *
     * @return JsonResponse
     */    
    public function index() : JsonResponse
    {
        return response()->json(Cars::all());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }
        /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/cars/",
     *      summary="Создать ТС",
     *      description="Создает новое ТС и возвращает ее",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/VehicleCreateRequest")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Возвращает запись созданного ТС",
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Неверно переданы данные в запросе",
     *      )
     * ),
     *
     * @param  CreateRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request) : JsonResponse
    {
        $cars = Cars::create($request->validated());

        return response()->json([
            'message' => 'Succesfully created',
            $cars->id => $cars
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/cars/{id}",
     *      summary="Получить ТС",
     *      description="Получает ТС по идентификатору и возвращает его",
     *      tags={"Машины"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Возвращает запись ТС",
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="ТС не найдено",
     *      )
     * ),
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        $cars = Cars::find($id);
        return response()->json([
            $cars->id => $cars
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cars $cars)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *      path="/api/cars/{id}",
     *      summary="Обновить ТС",
     *      description="Обновляет запись о ТС и возвращает ее",
     *      tags={"Машины"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\RequestBody(
     *          required=false,
     *          @OA\JsonContent(ref="#/components/schemas/VehicleUpdateRequest")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Возвращает запись ТС",
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Неверно передан идентификатор ТС",
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Неверно переданы данные в запросе",
     *      )
     * ),
     *
     * @param  UpdateRequest $request
     * @param  Vehicle $vehicle
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Cars $cars) : JsonResponse
    {
        $cars->update($request->validated());

        return response()->json([
            'message' => 'Succesfully updated',
            $cars->id => $cars
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/api/cars/{id}",
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
     *          response="200",
     *          description="Возвращает сообщение об успешном удалении",
     *          @OA\JsonContent(
     *              example={"message": "Succesfully destroyed"}
     *          ),
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Неверно передан идентификатор ТС",
     *      )
     * ),
     *
     * @param  Vehicle $vehicle
     * @return JsonResponse
     */
    public function destroy(Cars $cars) : JsonResponse
    {
        $cars->deleted();
        return response()->json(['message' => 'Succesfully destroyed'], 200);
    }
}
