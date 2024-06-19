<?php

namespace App\Http\Controllers;

use App\Models\Arendator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as Redis;
use App\Http\Requests\Arendators\StoreRequest;
use App\Http\Requests\Arendators\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ArendatorsController extends Controller
{
    /**
     * 
     * @OA\Get(
     *      path="/users",
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
    public function index() : JsonResponse
    {
        $cache = Redis::get('arend_index');
        if ($cache) {
            return $cache;
        }
        else {
            $cache = response()->json(Arendator::all());
            Redis::put('arend_index', $cache, now()->addMinutes(10));
            return $cache;
        }
    }

    /**
     *
     * @OA\Get(
     *      path="/users/{id}",
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
    public function show(string $id) : JsonResponse
    {
        return response()->json(Arendator::where('id', $id)->first());
    }

    /**
     *
     * @OA\Post(
     *      path="/users/create",
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
     *          description="Идентификатор пользователя. Создается автоматически, если поле пустое",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="string", example="0d2301a8-f20e-32eb-87f4-3630d5999c0b")
     *      ),
     *      @OA\Parameter(
     *          name="default_bill_id",
     *          description="Cчет по умолчанию",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="last_name",
     *          description="Фамилия арендатора",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="Haley")
     *      ),
     *      @OA\Parameter(
     *          name="first_name",
     *          description="Имя арендатора",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="Carolyn")
     *      ),
     *      @OA\Parameter(
     *          name="middle_name",
     *          description="Отчество арендатора",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="Berta")
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          description="Статус аккаунта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="active")
     *      ),
     *      @OA\Parameter(
     *          name="passport_series",
     *          description="Серия паспорта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="21 52")
     *      ),
     *      @OA\Parameter(
     *          name="passport_number",
     *          description="Номер паспорта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="string", example="026907")
     *      ),
     *      @OA\Parameter(
     *          name="phone",
     *          description="Номер телефона",
     *          required=true,
     *          in="query",
     *          @OA\Schema(type="integer", example="7525301782")
     *      ),
     *      @OA\Parameter(
     *          name="created_at",
     *          description="Дата создания записи",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="updated_at",
     *          description="Дата обновления записи",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="deleted_at",
     *          description="Дата удаления записи",
     *          required=false,
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
    public function store($request) : JsonResponse
    {
        $a = Arendator::create($request);
        return response()->json($a);
    }

    /**
     *
     * @OA\Patch(
     *      path="/users/{id}/update",
     *      summary="Обновить пользователя",
     *      description="Обновляет запись о пользователе и возвращает его",
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
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="default_bill_id",
     *          description="Cчет по умолчанию",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
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
     *          name="created_at",
     *          description="Дата создания записи",
     *          required=false,
     *          in="path",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="updated_at",
     *          description="Дата обновления записи",
     *          required=false,
     *          in="path",
     *          @OA\Schema(type="string", example="2024-05-17T13:22:34.000000Z")
     *      ),
     *      @OA\Parameter(
     *          name="deleted_at",
     *          description="Дата удаления записи",
     *          required=false,
     *          in="path",
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
    public function update(UpdateRequest $request, Arendator $a) : JsonResponse
    {
        $a->update($request->validated());

        return response()->json([
            'message' => 'Succesfully updated',
            $a->id => $a
        ], 200);
    }
    /**
     *
     * @OA\Delete(
     *      path="/users/{id}/delete",
     *      summary="Удалить пользователя",
     *      description="Удаляет запись о пользователе",
     *      tags={"Арендаторы"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Идентификатор пользователя",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer", example=1)
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
    public function destroy(Arendator $a) : JsonResponse
    {
        $a->delete();
        return response()->json(['message' => 'Succesfully destroyed'], 200);
    }
}