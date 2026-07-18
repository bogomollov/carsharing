<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarMark\StoreRequest;
use App\Http\Requests\CarMark\UpdateRequest;
use App\Http\Resources\CarMark\CarMarkResource;
use Illuminate\Support\Facades\Cache as Redis;
use App\Models\CarMark;
use OpenApi\Attributes as OA;

class CarMarkController extends Controller
{
    #[OA\Get(
        path: '/car-marks',
        summary: 'Получить все марки ТС',
        description: 'Получить список марок ТС',
        tags: ['Машины'],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarMarkAll')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
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

    #[OA\Get(
        path: '/car-marks/{id}',
        summary: 'Получить производителя ТС',
        description: 'Получает производителя ТС по идентификатору и возвращает его',
        tags: ['Машины'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор производителя', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarMarkId')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function show(CarMark $id)
    {
        $cache = Redis::get($id->id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new CarMarkResource($id);
            Redis::put($id->id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    #[OA\Post(
        path: '/car-marks',
        summary: 'Создать марку ТС',
        description: 'Создает новую марку ТС и возвращает ее',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarMarkRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarMarkRequest')])),
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarMarkChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function store(StoreRequest $request)
    {
        return new CarMarkResource(CarMark::create($request->validated()));
    }

    #[OA\Put(
        path: '/car-marks/{id}',
        summary: 'Обновить марку ТС',
        description: 'Обновляет запись о марке ТС и возвращает ее',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarMarkRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarMarkRequest')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Существующий идентификатор марки ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarMarkChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function update(UpdateRequest $request, CarMark $id)
    {
        $id->update($request->validated());
        return new CarMarkResource($id);
    }

    #[OA\Delete(
        path: '/car-marks/{id}',
        summary: 'Удалить марку ТС',
        description: 'Удаляет запись о марке ТС',
        tags: ['Машины'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор марки ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarMarkChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function destroy(CarMark $id)
    {
        $id->delete();
        return new CarMarkResource($id);
    }
}
