<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Bill;
use App\Models\Transaction;
use App\Services\BillService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as Redis;

class TransactionController extends Controller
{
    public function __construct(
        protected Transaction $transaction,
    ) {}

    /**
     * 
     * @OA\Get(
     *      path="/transaction",
     *      summary="Получить все транзакции",
     *      description="Получить транзакции",
     *      tags={"Транзакции"},
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Transaction")
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
        $cache = Redis::get('transaction_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = TransactionResource::collection(Transaction::all());
            Redis::put('transaction_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }
    /**
     *
     * @OA\Get(
     *      path="/transaction/{id}",
     *      summary="Получить транзакцию",
     *      description="Получает транзакцию по идентификатору и возвращает её",
     *      tags={"Транзакции"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор транзакции",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="1bbf9e65-a2ec-46e8-b155-5dac60831817")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Transaction")
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
    public function show(Transaction $id)
    {
        $cache = Redis::get($id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new TransactionResource($id);
            Redis::put($id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     *
     * @OA\Post(
     *      path="/transaction/create",
     *      summary="Создать транзакцию",
     *      description="Создает новую транзакцию и возвращает её",
     *      tags={"Транзакции"},
     *      @OA\RequestBody(
     *          request="TransactionCreate",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/TransactionCreate")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="arendator_id",
     *          description="Идентификатор арендатора",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="8f9a9586-4879-39d7-9040-423e5297cbc8")
     *      ),
     *      @OA\Parameter(
     *          name="bill_id",
     *          description="Идентификатор счета",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b")
     *      ),
     *      @OA\Parameter(
     *          name="modification",
     *          description="Изменение баланса",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="-500.00")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Transaction")
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
    public function store(StoreRequest $request, BillService $billService)
    {
        $a = Transaction::create($request->validated());
        $billService->modificateBalance($request->bill_id, $request->modification);
        return TransactionResource::make($a)->resolve();

    }

    /**
     *
     * @OA\Put(
     *      path="/transaction/{id}/update",
     *      summary="Обновить транзакцию",
     *      description="Обновляет запись о транзакции и возвращает её",
     *      tags={"Транзакции"},
     *      @OA\RequestBody(
     *          request="Transaction",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/Transaction")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Существующий идентификатор транзакции",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="1bbf9e65-a2ec-46e8-b155-5dac60831817")
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Новый идентификатор транзакции",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="bf03e5f6-b32c-4c3c-9435-6c4900c5ee22")
     *      ),
     *      @OA\Parameter(
     *          name="arendator_id",
     *          description="Новый идентификатор арендатора",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b")
     *      ),
     *      @OA\Parameter(
     *          name="bill_id",
     *          description="Новый идентификатор счета",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b")
     *      ),
     *      @OA\Parameter(
     *          name="modification",
     *          description="Новое изменение счета",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="-500.00")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Transaction")
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
    public function update(UpdateRequest $request, Transaction $id, BillService $billService)
    {
        $id->update($request->validated());
        $billService->modificateBalance(Bill::find($request->bill_id), $request->modification);
        return new TransactionResource($id);
    }
    /**
     *
     * @OA\Delete(
     *      path="/transaction/{id}/delete",
     *      summary="Удалить транзакцию",
     *      description="Удаляет транзакцию",
     *      tags={"Транзакции"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="deb4ff7a-c16b-4b9f-98db-d3c4e3cda010")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/Transaction")
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
    public function destroy(Transaction $id)
    {
        $id->delete();
        return new TransactionResource($id);
    }
}
