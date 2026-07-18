<?php

namespace App\Http\Controllers;

use App\Enums\CarsStatus;
use App\Models\Car;
use Illuminate\Support\Facades\Cache as Redis;
use App\Http\Requests\Car\StoreRequest;
use App\Http\Requests\Car\UpdateRequest;
use App\Http\Requests\Car\UpdateStatusRequest;
use App\Http\Resources\Car\CarResource;
use App\Services\CarService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use OpenApi\Attributes as OA;

class CarController extends Controller
{
    #[OA\Get(
        path: '/cars',
        summary: 'Получить все ТС',
        description: 'Получить список ТС',
        tags: ['Машины'],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarAll')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function index(): AnonymousResourceCollection
    {
        $cache = Redis::get('car_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = CarResource::collection(Car::all());
            Redis::put('car_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    #[OA\Get(
        path: '/cars/{id}',
        summary: 'Получить ТС',
        description: 'Получает ТС по идентификатору и возвращает его',
        tags: ['Машины'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор пользователя', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarId')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function show(Car $id): CarResource
    {
        $cache = Redis::get($id->id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new CarResource($id);
            Redis::put($id->id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    #[OA\Post(
        path: '/cars',
        summary: 'Создать ТС',
        description: 'Создает новое ТС и возвращает ее',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarRequest')])),
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function store(StoreRequest $request): CarResource
    {
        return new CarResource(Car::create($request->validated()));
    }

    #[OA\Put(
        path: '/cars/{id}',
        summary: 'Обновить ТС',
        description: 'Обновляет запись о ТС и возвращает ее',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarRequest')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Существующий идентификатор ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function update(UpdateRequest $request, Car $id): CarResource
    {
        $id->update($request->validated());
        return new CarResource($id);
    }

    #[OA\Delete(
        path: '/cars/{id}',
        summary: 'Удалить ТС',
        description: 'Удаляет запись о ТС',
        tags: ['Машины'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
            new OA\Response(response: 422, description: 'ТС уже в статусе ожидания', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response422')])),
        ],
    )]
    public function destroy(Car $id, CarService $carService): CarResource|JsonResponse
    {
        return $carService->setStatus($id, CarsStatus::Expectation);
    }

    #[OA\Patch(
        path: '/cars/{id}/status',
        summary: 'Обновить статус ТС',
        description: 'Обновляет статус ТС',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarStatus', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarStatus')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
            new OA\Response(response: 422, description: 'Статус уже установлен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response422')])),
        ],
    )]
    public function setStatus(UpdateStatusRequest $request, Car $id, CarService $carService): CarResource|JsonResponse {
        return $carService->setStatus($id, $request->validated()['status']);
    }

    #[OA\Get(
        path: '/cars/positions',
        summary: 'Получить текущие координаты арендованных ТС',
        description: 'Возвращает координаты всех ТС, находящихся в аренде, для отображения на карте',
        tags: ['Машины'],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(ref: '#/components/schemas/CarPositions')),
        ],
    )]
    public function positions(): Collection
    {
        return Car::query()
            ->where('status', CarsStatus::Rented)
            ->get(['id', 'location'])
            ->map(fn (Car $car) => [
                'id' => $car->id,
                'latitude' => $car->latitude,
                'longitude' => $car->longitude,
            ]);
    }
}
