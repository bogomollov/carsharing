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
use OpenApi\Attributes as OA;

class BillController extends Controller
{
    #[OA\Get(
        path: '/bills',
        summary: 'Получить все счета',
        description: 'Получить счета',
        tags: ['Счета'],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/BillAll')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
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

    #[OA\Get(
        path: '/bills/{id}',
        summary: 'Получить счет',
        description: 'Получает счет по идентификатору и возвращает его',
        tags: ['Счета'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор счета', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ff7f36b1-1cab-35b9-9b3f-969bb0e92109')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/BillId')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function show(Bill $id)
    {
        $cache = Redis::get($id->id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new BillResource($id);
            Redis::put($id->id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    #[OA\Post(
        path: '/bills',
        summary: 'Создать счет',
        description: 'Создает новый счет и возвращает его',
        tags: ['Счета'],
        requestBody: new OA\RequestBody(request: 'BillRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/BillRequest')])),
        responses: [
            new OA\Response(response: 201, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/BillChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function store(StoreRequest $request)
    {
        return new BillResource(Bill::create($request->validated()));
    }

    #[OA\Put(
        path: '/bills/{id}',
        summary: 'Обновить счет',
        description: 'Обновляет данные счета и возвращает его',
        tags: ['Счета'],
        requestBody: new OA\RequestBody(request: 'BillRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/BillRequest')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Существующий идентификатор счета', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ff7f36b1-1cab-35b9-9b3f-969bb0e92109')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/BillChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function update(UpdateRequest $request, Bill $id)
    {
        $id->update($request->validated());
        return new BillResource($id);
    }

    #[OA\Delete(
        path: '/bills/{id}',
        summary: 'Удалить счет',
        description: 'Удаляет запись о счете',
        tags: ['Счета'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор счета', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ff7f36b1-1cab-35b9-9b3f-969bb0e92109')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/BillChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function destroy(Bill $id, BillService $billService)
    {
        return $billService->setStatus($id, BillsStatus::Closed);
    }

    #[OA\Patch(
        path: '/bills/{id}/status',
        summary: 'Обновить статус счета',
        description: 'Обновляет статус счета',
        tags: ['Счета'],
        requestBody: new OA\RequestBody(request: 'BillStatus', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/BillStatus')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор счета', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ff7f36b1-1cab-35b9-9b3f-969bb0e92109')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/BillChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function setStatus(UpdateStatusRequest $request, Bill $id, BillService $billService) {
        return $billService->setStatus($id, $request['status']);
    }
}
