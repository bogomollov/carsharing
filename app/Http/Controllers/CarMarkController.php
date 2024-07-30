<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarMark\StoreRequest;
use App\Http\Requests\CarMark\UpdateRequest;
use App\Http\Resources\CarMark\CarMarkResource;
use Illuminate\Support\Facades\Cache as Redis;
use App\Models\CarMark;

class CarMarkController extends Controller
{
    /**
     * 
     * @OA\Get(
     *      path="/car_mark",
     *      summary="Получить все марки ТС",
     *      description="Получить список марок ТС",
     *      tags={"Машины"},
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarMarkAll")
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
        $cache = Redis::get('car_mark_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = CarMarkResource::collection(CarMark::all());
            Redis::put('car_mark_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     * 
     * @OA\Get(
     *      path="/car_mark/{id}",
     *      summary="Получить производителя ТС",
     *      description="Получает производителя ТС по идентификатору и возвращает его",
     *      tags={"Машины"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор производителя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarMarkId")
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
    public function show(CarMark $id)
    {
        $cache = Redis::get($id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new CarMarkResource($id);
            Redis::put($id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     * 
     * @OA\Post(
     *      path="/car_mark",
     *      summary="Создать марку ТС",
     *      description="Создает новую марку ТС и возвращает ее",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="CarMarkRequest",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarMarkRequest")
     *          }
     *      )    
     *  ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarMarkChange")
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
        return new CarMarkResource(CarMark::create($request->validated()));
    }

    /**
     * 
     * @OA\Put(
     *      path="/car_mark/{id}",
     *      summary="Обновить марку ТС",
     *      description="Обновляет запись о марке ТС и возвращает ее",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="Car",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarMarkRequest")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Существующий идентификатор марки ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarMarkChange")
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
    public function update(UpdateRequest $request, CarMark $id)
    {
        $id->update($request->validated());
        return new CarMarkResource($id);
    }

    /**
     * 
     * @OA\Delete(
     *      path="/car_mark/{id}",
     *      summary="Удалить марку ТС",
     *      description="Удаляет запись о марке ТС",
     *      tags={"Машины"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор марки ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarMarkChange")
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
    public function destroy(CarMark $id)
    {
        $id->delete();
        return new CarMarkResource($id);
    }
}
