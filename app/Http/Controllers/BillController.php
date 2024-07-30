<?php

namespace App\Http\Controllers;

use App\Enums\BillsStatus;
use App\Http\Resources\Bill\BillResource;
use App\Models\Bill;
use Illuminate\Support\Facades\Cache as Redis;
use App\Http\Requests\Bill\StoreRequest;
use App\Http\Requests\Bill\UpdateRequest;
use App\Http\Requests\Bill\UpdateStatusRequest;
use App\Services\BillService;
use Illuminate\Http\Request;

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
     *                  @OA\Schema(ref="#/components/schemas/BillAll")
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
     *                  @OA\Schema(ref="#/components/schemas/BillId")
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
     *      path="/bill",
     *      summary="Создать счет",
     *      description="Создает новый счет и возвращает его",
     *      tags={"Счета"},
     *      @OA\RequestBody(
     *          request="BillRequest",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/BillRequest")
     *          }
     *      )    
     *  ),
     *      @OA\Response(
     *          response=201,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/BillChange")
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
        return new BillResource(Bill::create($request->validated()));
    }

    /**
     *
     * @OA\Put(
     *      path="/bill/{id}",
     *      summary="Обновить счет",
     *      description="Обновляет данные счета и возвращает его",
     *      tags={"Счета"},
     *      @OA\RequestBody(
     *          request="BillRequest",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/BillRequest")
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
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/BillChange")
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
     *      path="/bill/{id}",
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
     *                  @OA\Schema(ref="#/components/schemas/BillChange")
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
    public function destroy(Bill $id, BillService $billService)
    {
        return $billService->setStatus($id, BillsStatus::Closed);
    }

    /**
     *
     * @OA\Patch(
     *      path="/bill/{id}/status",
     *      summary="Обновить статус счета",
     *      description="Обновляет статус счета",
     *      tags={"Счета"},
     *      @OA\RequestBody(
     *          request="BillStatus",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/BillStatus")
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
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/BillChange")
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
    public function setStatus(UpdateStatusRequest $request, Bill $id, BillService $billService) {
        return $billService->setStatus($id, $request->validated()['status']);
    }
}
