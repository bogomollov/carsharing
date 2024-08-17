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
use Illuminate\Support\Facades\Cache as Redis;

class CarModelController extends Controller
{
    /**
     * 
     * @OA\Get(
     *      path="/car_model",
     *      summary="Получить все модели ТС",
     *      description="Получить список моделей ТС",
     *      tags={"Машины"},
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelAll")
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

    /**
     * 
     * @OA\Get(
     *      path="/car_model/{id}",
     *      summary="Получить модель ТС",
     *      description="Получает модель ТС по идентификатору и возвращает его",
     *      tags={"Машины"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор модели",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelId")
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
     * )
     *
     */
    public function show(CarModel $id)
    {
        $cache = Redis::get($id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new CarModelResource($id);
            Redis::put($id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     * 
     * @OA\Post(
     *      path="/car_model",
     *      summary="Создать модель ТС",
     *      description="Создает новую модель ТС и возвращает ее",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="CarModelRequest",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarModelRequest")
     *          }
     *      )    
     *  ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelChange")
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
     *  ),
     */
    public function store(StoreRequest $request)
    {
        return new CarModelResource(CarModel::create($request->validated()));
    }

    /**
     * 
     * @OA\Put(
     *      path="/car_model/{id}",
     *      summary="Обновить модель ТС",
     *      description="Обновляет запись о модели ТС и возвращает ее",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="Car",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarModelRequest")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Существующий идентификатор модели ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelChange")
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
    public function update(UpdateRequest $request, CarModel $id)
    {
        $id->update($request->validated());
        return new CarModelResource($id);
    }

    /**
     * 
     * @OA\Delete(
     *      path="/car_model/{id}",
     *      summary="Удалить модель ТС",
     *      description="Удаляет запись о модели ТС",
     *      tags={"Машины"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор модели ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelChange")
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
    public function destroy(CarModel $id)
    {
        $id->delete();
        return new CarModelResource($id);
    }

    /**
     * 
     * @OA\Patch(
     *      path="/car_model/{id}/mark",
     *      summary="Обновить марку ТС",
     *      description="Обновляет марку ТС",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="CarModelMark",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarModelMark")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор модели ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelChange")
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
    public function setMark(UpdateMarkRequest $request, CarModel $id) {
        $id->mark_id = $request->validated()['mark_id'];
        $id->update();
        return new CarModelResource($id);
    }

    /**
     * 
     * @OA\Patch(
     *      path="/car_model/{id}/class",
     *      summary="Обновить класс ТС по престижу",
     *      description="Обновляет класс ТС по престижу",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="CarModelClass",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarModelClass")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор модели ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelChange")
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
    public function setClass(UpdateClassRequest $request, CarModel $id) {
        $id->car_class = $request->validated()['car_class'];
        $id->update();
        return new CarModelResource($id);
    }

    /**
     * 
     * @OA\Patch(
     *      path="/car_model/{id}/type",
     *      summary="Обновить тип кузова у модели ТС",
     *      description="Обновляет тип кузова у модели ТС",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="CarModelType",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarModelType")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор модели ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelChange")
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
    public function setType(UpdateTypeRequest $request, CarModel $id) {
        $id->car_type = $request->validated()['car_type'];
        $id->update();
        return new CarModelResource($id);
    }

    /**
     * 
     * @OA\Patch(
     *      path="/car_model/{id}/fuel",
     *      summary="Обновить тип топлива у модели ТС",
     *      description="Обновляет тип топлива у модели ТС",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="CarModelFuelType",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarModelFuelType")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор модели ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelChange")
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
    public function setFuelType(UpdateFuelTypeRequest $request, CarModel $id) {
        $id->fuel_type = $request->validated()['fuel_type'];
        $id->update();
        return new CarModelResource($id);
    }

    /**
     * 
     * @OA\Patch(
     *      path="/car_model/{id}/gearbox",
     *      summary="Обновить тип коробки передач у модели ТС",
     *      description="Обновляет тип коробки передач у модели ТС",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="CarModelGearBoxType",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarModelGearBoxType")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор модели ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelChange")
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
    public function setGearBox(UpdateGearBoxTypeRequest $request, CarModel $id) {
        $id->gear_box = $request->validated()['gear_box'];
        $id->update();
        return new CarModelResource($id);
    }

    /**
     * 
     * @OA\Patch(
     *      path="/car_model/{id}/drive",
     *      summary="Обновить тип привода у модели ТС",
     *      description="Обновляет тип привода у модели ТС",
     *      tags={"Машины"},
     *      @OA\RequestBody(
     *          request="CarModelDriveType",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/CarModelDriveType")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор модели ТС",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="ca327b1a-ed73-41c6-afe0-1eca33866ec3")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/CarModelChange")
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
    public function setDriveType(UpdateDriveTypeRequest $request, CarModel $id) {
        $id->drive_type = $request->validated()['drive_type'];
        $id->update();
        return new CarModelResource($id);
    }
}
