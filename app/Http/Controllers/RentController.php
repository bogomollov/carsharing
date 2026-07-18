<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rent\CloseRequest;
use App\Http\Requests\Rent\OpenRequest;
use App\Models\Rent;
use Illuminate\Support\Facades\Cache as Redis;
use App\Http\Requests\Rent\UpdateRequest;
use App\Http\Requests\Rent\UpdateStatusRequest;
use App\Http\Resources\Rent\RentResource;
use App\Services\RentService;
use OpenApi\Attributes as OA;

class RentController extends Controller
{
    #[OA\Get(
        path: '/rents',
        summary: 'Получить все аренды',
        description: 'Получить аренды',
        tags: ['Аренды'],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/RentAll')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
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

    #[OA\Get(
        path: '/rents/{id}',
        summary: 'Получить аренду',
        description: 'Получает аренду по идентификатору и возвращает его',
        tags: ['Аренды'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор аренды', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'beceda62-2656-3617-97b9-b686a7d36e3b')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/RentId')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function show(Rent $id)
    {
        $cache = Redis::get($id->id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new RentResource($id);
            Redis::put($id->id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    #[OA\Post(
        path: '/rents',
        summary: 'Открыть аренду',
        description: 'Открывает новую аренду и возвращает её',
        tags: ['Аренды'],
        requestBody: new OA\RequestBody(request: 'RentOpen', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/RentOpen')])),
        responses: [
            new OA\Response(response: 201, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/RentChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function store(OpenRequest $request, RentService $rentService)
    {
        $val = $request->validated();
        return $rentService->open($val['arendator_id'], $val['car_id']);
    }

    #[OA\Put(
        path: '/rents/{id}',
        summary: 'Обновить аренду',
        description: 'Обновляет аренду и возвращает её',
        tags: ['Аренды'],
        requestBody: new OA\RequestBody(request: 'RentRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/RentRequest')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор аренды', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'beceda62-2656-3617-97b9-b686a7d36e3b')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/RentChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function update(UpdateRequest $request, Rent $id)
    {
        $id->update($request->validated());
        return new RentResource($id);
    }

    #[OA\Delete(
        path: '/rents/{id}',
        summary: 'Удалить запись об аренде',
        description: 'Удаляет запись об аренде и возвращает её',
        tags: ['Аренды'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор аренды', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'beceda62-2656-3617-97b9-b686a7d36e3b')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/RentChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function destroy(Rent $id)
    {
        $id->delete();
        return new RentResource($id);
    }

    #[OA\Patch(
        path: '/rents/{id}',
        summary: 'Закрыть аренду',
        description: 'Закрывает аренду и возвращает её',
        tags: ['Аренды'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор аренды', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ff7f36b1-1cab-35b9-9b3f-969bb0e92109')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/RentChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function closeRent(Rent $id, RentService $rentService) {
        return $rentService->close($id);
    }
}
