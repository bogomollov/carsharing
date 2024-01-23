<?php

namespace App\Http\Controllers;

use App\Models\Arendators;
use App\Http\Resources\Arendators\ArendatorsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Arendators\StoreRequest;
use App\Http\Requests\Arendators\UpdateRequest;
use Illuminate\Http\JsonResponse;

class ArendatorsController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *      path="/api/users/",
     *      summary="Получить всех пользователей",
     *      description="Получить пользователей",
     *      tags={"Арендаторы"},
     *      @OA\Response(
     *          response="200",
     *          description="Возвращает список пользователей",
     *      )
     * ),
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return response()->json(Arendators::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

        /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *      path="/api/users/",
     *      summary="Создать пользователя",
     *      description="Создает нового пользователя и возвращает его",
     *      tags={"Арендаторы"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/VehicleCreateRequest")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Возвращает запись созданного пользователя",
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Неверно переданы данные в запросе",
     *      )
     * ),
     *
     * @param  StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request) : JsonResponse
    {
        $a = Arendators::create($request->validated());
        return response()->json([
            'message' => 'Succesfully created',
            $a->id => $a
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *      path="/api/users/{id}",
     *      summary="Получить пользователя",
     *      description="Получает пользователя по идентификатору и возвращает его",
     *      tags={"Арендаторы"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="Возвращает запись пользователя",
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Пользователь не найден",
     *      )
     * ),
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        $a = Arendators::find($id);
        return response()->json([
            $a->id => $a
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $users)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @OA\Patch(
     *      path="/api/users/{id}",
     *      summary="Обновить пользователя",
     *      description="Обновляет запись о пользователе и возвращает его",
     *      tags={"Арендаторы"},
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
     *          description="Возвращает запись пользователя",
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Неверно передан идентификатор пользователя",
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Неверно переданы данные в запросе",
     *      )
     * ),
     *
     * @param  UpdateRequest $request
     * @param  Arendators $a
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Arendators $a) : JsonResponse
    {
        $a->update($request->validated());

        return response()->json([
            'message' => 'Succesfully updated',
            $a->id => $a
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      summary="Удалить пользователя",
     *      description="Удаляет запись о пользователе",
     *      tags={"Арендаторы"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор пользователя",
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
     *          description="Неверно передан идентификатор пользователя",
     *      )
     * ),
     *
     * @param  Arendators $a
     * @return JsonResponse
     */
    public function destroy(Arendators $a) : JsonResponse
    {
        $a->deleted();
        return response()->json(['message' => 'Succesfully destroyed'], 200);
    }
}
