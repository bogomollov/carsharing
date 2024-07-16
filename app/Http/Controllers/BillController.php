<?php

namespace App\Http\Controllers;

use App\Http\Resources\Bill\BillResource;
use App\Models\Bill;
use Illuminate\Support\Facades\Cache as Redis;
use App\Http\Requests\Bill\StoreRequest;
use App\Http\Requests\Bill\UpdateRequest;

class BillController extends Controller
{
    /**
     * 
     * @OA\Get(
     *      path="/bill",
     *      summary="Получить все счета",
     *      description="Получить счета",
     *      tags={"Счета"},
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Bill")
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
        $cache = Redis::get('bill_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = BillResource::collection(Bill::all());
            Redis::put('bill_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/bill/{id}",
     *      summary="Получить счет",
     *      description="Получает счет по идентификатору и возвращает его",
     *      tags={"Счета"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор счета",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ff7f36b1-1cab-35b9-9b3f-969bb0e92109")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Bill")
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
    public function show(Bill $id)
    {
        $cache = Redis::get($id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new BillResource($id);
            Redis::put($id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     *
     * @OA\Post(
     *      path="/bill/create",
     *      summary="Создать счет",
     *      description="Создает новый счет и возвращает его",
     *      tags={"Счета"},
     *      @OA\RequestBody(
     *          request="Bill",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/Bill")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор счета",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ff7f36b1-1cab-35b9-9b3f-969bb0e92109")
     *      ),
     *      @OA\Parameter(
     *          name="arendators_count",
     *          description="Количество пользователей связанных со счётом",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="balance",
     *          description="Баланс счёта",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="48658.52")
     *      ),
     *      @OA\Parameter(
     *          name="type",
     *          description="Тип счёта",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="personal")
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Статус счёта",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="open")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Bill")
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
    public function store(StoreRequest $request)
    {
        $a = Bill::create($request->validated());
        return BillResource::make($a)->resolve();
    }

    /**
     *
     * @OA\Put(
     *      path="/bill/{id}/update",
     *      summary="Обновить счет",
     *      description="Обновляет данные счета и возвращает его",
     *      tags={"Счета"},
     *      @OA\RequestBody(
     *          request="Bill",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/Bill")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Существующий идентификатор счета",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ff7f36b1-1cab-35b9-9b3f-969bb0e92109")
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Новый идентификатор счета",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="8afe0a60-944f-3fa7-a493-f907632084fb")
     *      ),
     *      @OA\Parameter(
     *          name="arendators_count",
     *          description="Новое количество пользователей связанных со счётом",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="balance",
     *          description="Новый баланс счёта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="48658.52")
     *      ),
     *      @OA\Parameter(
     *          name="type",
     *          description="Новый тип счёта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="personal")
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Новый статус счёта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="open")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Bill")
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
    public function update(UpdateRequest $request, Bill $id)
    {
        $id->update($request->validated());
        return new BillResource($id);
    }
    /**
     *
     * @OA\Delete(
     *      path="/bill/{id}/delete",
     *      summary="Удалить счет",
     *      description="Удаляет запись о счете",
     *      tags={"Счета"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор счета",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ff7f36b1-1cab-35b9-9b3f-969bb0e92109")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Bill")
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
    public function destroy(Bill $id)
    {
        $id->delete();
        return new BillResource($id);
    }
}
