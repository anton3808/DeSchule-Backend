<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\User\Events\Auth\UserRegisteredEvent;
use Modules\User\Http\Requests\Auth\ChangePasswordRequest;
use Modules\User\Http\Requests\Auth\LoginRequest;
use Modules\User\Http\Requests\Auth\RegisterRequest;
use Modules\User\Transformers\UserResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create(array_merge($request->validated(), [
            'password' => bcrypt($request->get('password'))
        ]));
        $token = $user->createToken('accessToken');

        event(new UserRegisteredEvent($user));

        return response()->json([
            'access_token' => $token->plainTextToken,
            'user'         => UserResource::make($user)
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response(null, 200);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::wherePhone($request->get('login'))
            ->orWhere('email', $request->get('login'))
            ->orWhere('login', $request->get('login'))
            ->first();
        $token = $user->createToken('accessToken');
        return response()->json([
            'access_token' => $token->plainTextToken,
            'user'         => UserResource::make($user)
        ]);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = request()->user('sanctum');
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return response()->json();
    }
}
