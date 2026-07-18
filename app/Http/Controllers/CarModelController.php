<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarModel\StoreRequest;
use App\Http\Requests\CarModel\UpdateClassRequest;
use App\Http\Requests\CarModel\UpdateDriveTypeRequest;
use App\Http\Requests\CarModel\UpdateFuelTypeRequest;
use App\Http\Requests\CarModel\UpdateGearBoxTypeRequest;
use App\Http\Requests\CarModel\UpdateMarkRequest;
use App\Http\Requests\CarModel\UpdateRequest;
use App\Http\Requests\CarModel\UpdateTypeRequest;
use App\Http\Resources\CarModel\CarModelResource;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache as Redis;
use OpenApi\Attributes as OA;

class CarModelController extends Controller
{
    #[OA\Get(
        path: '/car-models',
        summary: 'Получить все модели ТС',
        description: 'Получить список моделей ТС',
        tags: ['Машины'],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelAll')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function index(): AnonymousResourceCollection
    {
        $cache = Redis::get('car_model_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = CarModelResource::collection(CarModel::all());
            Redis::put('car_model_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    #[OA\Get(
        path: '/car-models/{id}',
        summary: 'Получить модель ТС',
        description: 'Получает модель ТС по идентификатору и возвращает его',
        tags: ['Машины'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор модели', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelId')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function show(CarModel $id): CarModelResource
    {
        $cache = Redis::get($id->id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new CarModelResource($id);
            Redis::put($id->id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    #[OA\Post(
        path: '/car-models',
        summary: 'Создать модель ТС',
        description: 'Создает новую модель ТС и возвращает ее',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarModelRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarModelRequest')])),
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function store(StoreRequest $request): CarModelResource
    {
        return new CarModelResource(CarModel::create($request->validated()));
    }

    #[OA\Put(
        path: '/car-models/{id}',
        summary: 'Обновить модель ТС',
        description: 'Обновляет запись о модели ТС и возвращает ее',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarModelRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarModelRequest')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Существующий идентификатор модели ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function update(UpdateRequest $request, CarModel $id): CarModelResource
    {
        $id->update($request->validated());
        return new CarModelResource($id);
    }

    #[OA\Delete(
        path: '/car-models/{id}',
        summary: 'Удалить модель ТС',
        description: 'Удаляет запись о модели ТС',
        tags: ['Машины'],
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор модели ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function destroy(CarModel $id): CarModelResource
    {
        $id->delete();
        return new CarModelResource($id);
    }

    #[OA\Patch(
        path: '/car-models/{id}/mark',
        summary: 'Обновить марку ТС',
        description: 'Обновляет марку ТС',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarModelMark', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarModelMark')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор модели ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function setMark(UpdateMarkRequest $request, CarModel $id): CarModelResource {
        $id->mark_id = $request->validated()['mark_id'];
        $id->update();
        return new CarModelResource($id);
    }

    #[OA\Patch(
        path: '/car-models/{id}/class',
        summary: 'Обновить класс ТС по престижу',
        description: 'Обновляет класс ТС по престижу',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarModelClass', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarModelClass')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор модели ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function setClass(UpdateClassRequest $request, CarModel $id): CarModelResource {
        $id->car_class = $request->validated()['car_class'];
        $id->update();
        return new CarModelResource($id);
    }

    #[OA\Patch(
        path: '/car-models/{id}/type',
        summary: 'Обновить тип кузова у модели ТС',
        description: 'Обновляет тип кузова у модели ТС',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarModelType', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarModelType')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор модели ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function setType(UpdateTypeRequest $request, CarModel $id): CarModelResource {
        $id->car_type = $request->validated()['car_type'];
        $id->update();
        return new CarModelResource($id);
    }

    #[OA\Patch(
        path: '/car-models/{id}/fuel',
        summary: 'Обновить тип топлива у модели ТС',
        description: 'Обновляет тип топлива у модели ТС',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarModelFuelType', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarModelFuelType')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор модели ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function setFuelType(UpdateFuelTypeRequest $request, CarModel $id): CarModelResource {
        $id->fuel_type = $request->validated()['fuel_type'];
        $id->update();
        return new CarModelResource($id);
    }

    #[OA\Patch(
        path: '/car-models/{id}/gearbox',
        summary: 'Обновить тип коробки передач у модели ТС',
        description: 'Обновляет тип коробки передач у модели ТС',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarModelGearBoxType', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarModelGearBoxType')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор модели ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function setGearBox(UpdateGearBoxTypeRequest $request, CarModel $id): CarModelResource {
        $id->gear_box = $request->validated()['gear_box'];
        $id->update();
        return new CarModelResource($id);
    }

    #[OA\Patch(
        path: '/car-models/{id}/drive',
        summary: 'Обновить тип привода у модели ТС',
        description: 'Обновляет тип привода у модели ТС',
        tags: ['Машины'],
        requestBody: new OA\RequestBody(request: 'CarModelDriveType', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/CarModelDriveType')])),
        parameters: [
            new OA\Parameter(name: 'id', description: 'Идентификатор модели ТС', required: true, in: 'path', schema: new OA\Schema(type: 'string', example: 'ca327b1a-ed73-41c6-afe0-1eca33866ec3')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/CarModelChange')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response401')])),
            new OA\Response(response: 403, description: 'Доступ запрещен', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response403')])),
            new OA\Response(response: 404, description: 'Не найдено', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/Response404')])),
        ],
    )]
    public function setDriveType(UpdateDriveTypeRequest $request, CarModel $id): CarModelResource {
        $id->drive_type = $request->validated()['drive_type'];
        $id->update();
        return new CarModelResource($id);
    }
}
