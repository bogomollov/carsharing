<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    #[OA\Post(
        path: '/auth/login',
        summary: 'Войти',
        description: 'Аутентифицирует пользователя по email и паролю и возвращает JWT',
        tags: ['Аутентификация'],
        security: [],
        requestBody: new OA\RequestBody(request: 'AuthLoginRequest', required: true, content: new OA\JsonContent(allOf: [new OA\Schema(ref: '#/components/schemas/AuthLoginRequest')])),
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/AuthToken')])),
            new OA\Response(response: 401, description: 'Неверные учетные данные', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/AuthLoginError')])),
        ],
    )]
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    #[OA\Post(
        path: '/auth/me',
        summary: 'Получить текущего пользователя',
        description: 'Возвращает пользователя, соответствующего переданному JWT',
        tags: ['Аутентификация'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/AuthUser')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/AuthUnauthenticated')])),
        ],
    )]
    public function me(): JsonResponse
    {
        return response()->json(auth('api')->user());
    }

    #[OA\Post(
        path: '/auth/logout',
        summary: 'Выйти',
        description: 'Аннулирует переданный JWT',
        tags: ['Аутентификация'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/AuthLogoutResponse')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/AuthUnauthenticated')])),
        ],
    )]
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    #[OA\Post(
        path: '/auth/refresh',
        summary: 'Обновить токен',
        description: 'Обновляет переданный JWT и возвращает новый',
        tags: ['Аутентификация'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Успех', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/AuthToken')])),
            new OA\Response(response: 401, description: 'Не авторизован', content: new OA\JsonContent(oneOf: [new OA\Schema(ref: '#/components/schemas/AuthUnauthenticated')])),
        ],
    )]
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
