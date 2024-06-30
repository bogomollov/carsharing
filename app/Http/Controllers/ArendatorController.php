<?php

namespace App\Http\Controllers;

use App\Models\Arendator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as Redis;
use App\Http\Requests\Arendators\StoreRequest;
use App\Http\Requests\Arendators\UpdateRequest;
use App\Http\Resources\Arendator\ArendatorResource;
use Illuminate\Http\Response;

class ArendatorController extends Controller
{
    /**
     * 
     * @OA\Get(
     *      path="/user",
     *      summary="Получить всех пользователей",
     *      description="Получить пользователей",
     *      tags={"Арендаторы"},
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/User")
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
        $cache = Redis::get('arend_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = ArendatorResource::collection(Arendator::all());
            Redis::put('arend_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/user/{id}",
     *      summary="Получить пользователя",
     *      description="Получает пользователя по идентификатору и возвращает его",
     *      tags={"Арендаторы"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="45c746aa-64e1-349c-8a94-9daf95d36c52")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/User")
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
    public function show($id)
    {
        $cache = Redis::get($id);
        if ($cache) {
            return $cache;
        }
        else {
            $cache = new ArendatorResource(Arendator::findOrFail($id));
            Redis::put($id, $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     *
     * @OA\Post(
     *      path="/user/create",
     *      summary="Создать пользователя",
     *      description="Создает нового пользователя и возвращает его",
     *      tags={"Арендаторы"},
     *      @OA\RequestBody(
     *          request="PostUser",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/User")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="45c746aa-64e1-349c-8a94-9daf95d36c52")
     *      ),
     *      @OA\Parameter(
     *          name="default_bill_id",
     *          description="Cчет по умолчанию",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b")
     *      ),
     *      @OA\Parameter(
     *          name="last_name",
     *          description="Фамилия арендатора",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="Haley")
     *      ),
     *      @OA\Parameter(
     *          name="first_name",
     *          description="Имя арендатора",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="Carolyn")
     *      ),
     *      @OA\Parameter(
     *          name="middle_name",
     *          description="Отчество арендатора",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="Berta")
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Статус аккаунта",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="active")
     *      ),
     *      @OA\Parameter(
     *          name="passport_series",
     *          description="Серия паспорта",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="21 52")
     *      ),
     *      @OA\Parameter(
     *          name="passport_number",
     *          description="Номер паспорта",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="026907")
     *      ),
     *      @OA\Parameter(
     *          name="phone",
     *          description="Номер телефона",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example="7525301782")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/User")
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
        $a = Arendator::create($request->validated());
        return ArendatorResource::make($a)->resolve();
    }

    /**
     *
     * @OA\Put(
     *      path="/user/{id}/update",
     *      summary="Обновить пользователя",
     *      description="Обновляет запись о пользователе и возвращает его",
     *      tags={"Арендаторы"},
     *      @OA\RequestBody(
     *          request="UpdateRequest",
     *          required=true,
     *      @OA\JsonContent(
     *          allOf={
     *              @OA\Schema(ref="#/components/schemas/User")
     *          }
     *      )    
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Существующий идентификатор пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="64a7129a-fc61-3d3f-b44a-837d29f6531a")
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Новый идентификатор пользователя",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="45c746aa-64e1-349c-8a94-9daf95d36c52")
     *      ),
     *      @OA\Parameter(
     *          name="default_bill_id",
     *          description="Новый счет по умолчанию",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="5z7490a8-f20e-32eb-87f4-3630d5999c0b")
     *      ),
     *      @OA\Parameter(
     *          name="last_name",
     *          description="Новая фамилия арендатора",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="Haley")
     *      ),
     *      @OA\Parameter(
     *          name="first_name",
     *          description="Новое имя арендатора",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="Carolyn")
     *      ),
     *      @OA\Parameter(
     *          name="middle_name",
     *          description="Новое отчество арендатора",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="Berta")
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Новый статус аккаунта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="active")
     *      ),
     *      @OA\Parameter(
     *          name="passport_series",
     *          description="Новая серия паспорта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="21 52")
     *      ),
     *      @OA\Parameter(
     *          name="passport_number",
     *          description="Новый номер паспорта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="026907")
     *      ),
     *      @OA\Parameter(
     *          name="phone",
     *          description="Новый номер телефона",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="integer", example="7525301782")
     *      ),
     *      @OA\Parameter(
     *          name="created_at",
     *          description="Новая дата создания записи",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="updated_at",
     *          description="Новая дата обновления записи",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="deleted_at",
     *          description="Новая дата удаления записи",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/User")
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
    public function update(UpdateRequest $request, $id)
    {
        $a = Arendator::findOrFail($id)->update($request->validated());
        // $a->id = $request['id'];
        // $a->default_bill_id = $request['default_bill_id'];
        // $a->last_name = $request['last_name'];
        // $a->first_name =  $request['first_name'];
        // $a->middle_name = $request['middle_name'];
        // $a->status = $request['status'];
        // $a->passport_series = $request['passport_series'];
        // $a->passport_number = $request['passport_number'];
        // $a->phone = $request['phone'];
        // $a->created_at = $request['created_at'];
        // $a->updated_at = $request['updated_at'];
        // $a->deleted_at = $request['deleted_at'];
        // $a->save();
        return new ArendatorResource($a);
    }
    /**
     *
     * @OA\Delete(
     *      path="/user/{id}/delete",
     *      summary="Удалить пользователя",
     *      description="Удаляет запись о пользователе",
     *      tags={"Арендаторы"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string", example="45c746aa-64e1-349c-8a94-9daf95d36c52")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(
     *              oneOf={
     *                  @OA\Schema(ref="#/components/schemas/User")
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
    public function destroy(Arendator $arendator)
    {
        $arendator->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}