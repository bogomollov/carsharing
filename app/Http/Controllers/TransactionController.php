<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreRequest;
use App\Http\Requests\Transaction\UpdateRequest;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Bill;
use App\Models\Transaction;
use App\Services\BillService;
use Illuminate\Support\Facades\Cache as Redis;
use OpenApi\Attributes as OA;

class TransactionController extends Controller
{
    #[OA\Get(
        path: '/transactions',
        summary: 'Получить все транзакции',
        description: 'Получить транзакции',
        tags: ['Транзакции'],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/TransactionAll')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
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

    #[OA\Get(
        path: '/transactions/{id}',
        summary: 'Получить транзакцию',
        description: 'Получает транзакцию по идентификатору и возвращает её',
        tags: ['Транзакции'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор транзакции', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: '1bbf9e65-a2ec-46e8-b155-5dac60831817')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/TransactionId')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function show(Transaction $id)
    {
        $cache = Redis::get($id->id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new TransactionResource($id);
            Redis::put($id->id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    #[OA\Post(
        path: '/transactions',
        summary: 'Создать транзакцию',
        description: 'Создает новую транзакцию и возвращает её',
        tags: ['Транзакции'],
        requestBody: new OA\RequestBody(request: 'TransactionRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/TransactionRequest')])),
        responses: [
            new OA\Response(response: 201, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/TransactionChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function store(StoreRequest $request)
    {
        return new TransactionResource(Transaction::create($request->validated()));
    }

    #[OA\Put(
        path: '/transactions/{id}',
        summary: 'Обновить транзакцию',
        description: 'Обновляет запись о транзакции и возвращает её',
        tags: ['Транзакции'],
        requestBody: new OA\RequestBody(request: 'TransactionRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/TransactionRequest')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор транзакции', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'beceda62-2656-3617-97b9-b686a7d36e3b')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/TransactionChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function update(UpdateRequest $request, Transaction $id)
    {
        $id->update($request->validated());
        return new TransactionResource($id);
    }

    #[OA\Delete(
        path: '/transactions/{id}',
        summary: 'Удалить транзакцию',
        description: 'Удаляет транзакцию',
        tags: ['Транзакции'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор пользователя', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'deb4ff7a-c16b-4b9f-98db-d3c4e3cda010')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/TransactionChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function destroy(Transaction $id)
    {
        $id->delete();
        return new TransactionResource($id);
    }
}
