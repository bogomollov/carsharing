<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rent\CloseRequest;
use App\Http\Requests\Rent\OpenRequest;
use App\Models\Rent;
use Illuminate\Support\Facades\Cache as Redis;
use App\Http\Requests\Rent\UpdateRequest;
use App\Http\Resources\Rent\RentResource;
use App\Services\RentService;

class RentController extends Controller
{
    /**
     * 
     * @OA\Get(
     *      path="/rent",
     *      summary="Получить все аренды",
     *      description="Получить аренды",
     *      tags={"Аренды"},
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Rent")
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
        $cache = Redis::get('rent_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = RentResource::collection(Rent::all());
            Redis::put('rent_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/rent/{id}",
     *      summary="Получить аренду",
     *      description="Получает аренду по идентификатору и возвращает его",
     *      tags={"Аренды"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор аренды",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="beceda62-2656-3617-97b9-b686a7d36e3b")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Rent")
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
     *
     */
    public function show(Rent $id)
    {
        $cache = Redis::get($id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new RentResource($id);
            Redis::put($id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     *
     * @OA\Post(
     *      path="/rent/create",
     *      summary="Открыть аренду",
     *      description="Открывает новую аренду и возвращает её",
     *      tags={"Аренды"},
     *      @OA\RequestBody(
     *          request="Rent",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/RentOpen")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="car_id",
     *          description="Идентификатор ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="88315283-5248-416f-b788-567b981b6d89")
     *      ),
     *      @OA\Parameter(
     *          name="arendator_id",
     *          description="Идентификатор арендатора",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="324f2c0d-0217-47a5-a3a1-0555d7f10a0a")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Rent")
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
     *
     */
    public function store(OpenRequest $request, RentService $rentService)
    {
        return $rentService->open($request->arendator_id, $request->car_id);
    }

    /**
     *
     * @OA\Put(
     *      path="/rent/{id}/update",
     *      summary="Обновить аренду",
     *      description="Обновляет аренду и возвращает её",
     *      tags={"Аренды"},
     *      @OA\RequestBody(
     *          request="Rent",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/Rent")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Существующий идентификатор аренды",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="beceda62-2656-3617-97b9-b686a7d36e3b")
     *      ),
     *      @OA\Parameter(
     *          name="car_id",
     *          description="Новый идентификатор ТС",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="324f2c0d-0217-47a5-a3a1-0555d7f10a0a")
     *      ),
     *      @OA\Parameter(
     *          name="arendator_id",
     *          description="Новый идентификатор арендатора",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="324f2c0d-0217-47a5-a3a1-0555d7f10a0a")
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Новый статус аренды",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="open")
     *      ),
     *      @OA\Parameter(
     *          name="start_datetime",
     *          description="Новая дата и время начала аренды",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="2024-07-06 19:52:25")
     *      ),
     *      @OA\Parameter(
     *          name="end_datetime",
     *          description="Новая дата и время окончания аренды",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="2024-07-06 19:52:25")
     *      ),
     *      @OA\Parameter(
     *          name="rented_time",
     *          description="Новое общее время аренды",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="integer", example=720)
     *      ),
     *      @OA\Parameter(
     *          name="total_price",
     *          description="Новая итоговая цена аренды",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="numeric", example=8658.32)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Rent")
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
     *
     */
    public function update(UpdateRequest $request, Rent $id)
    {
        $id->update($request->validated());
        return new RentResource($id);
    }
    /**
     *
     * @OA\Delete(
     *      path="/rent/{id}/delete",
     *      summary="Закрыть аренду",
     *      description="Закрывает аренду",
     *      tags={"Аренды"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор аренды",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="beceda62-2656-3617-97b9-b686a7d36e3b")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/RentClose")
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
     *
     */
    public function destroy(CloseRequest $request, RentService $rentService)
    {
        return $rentService->close($request->id);
    }
}
