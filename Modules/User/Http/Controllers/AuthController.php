<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\User\Entities\User;
use Modules\User\Events\Auth\UserChangePasswordEvent;
use Modules\User\Events\Auth\UserRegisteredEvent;
use Modules\User\Http\Requests\Auth\ChangePasswordRequest;
use Modules\User\Http\Requests\Auth\LoginRequest;
use Modules\User\Http\Requests\Auth\RegisterRequest;
use Modules\User\Http\Requests\Auth\ResetPasswordConfirmationRequest;
use Modules\User\Http\Requests\Auth\ResetPasswordRequest;
use Modules\User\Transformers\UserResource;
use Psr\SimpleCache\InvalidArgumentException;

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
        $request->user('sanctum')->currentAccessToken()->delete();
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
        $user = $request->user('sanctum');
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return response()->json([
            'message' => __('auth.password-changed')
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::wherePhone($request->get('login'))
            ->orWhere('email', $request->get('login'))
            ->orWhere('login', $request->get('login'))->first();

        event(new UserChangePasswordEvent($user));

        return response()->json([
            'message' => __('auth.mail-sent')
        ]);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function resetPasswordConfirmation(ResetPasswordConfirmationRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::findOrFail(Cache::get($request->get('code')));
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        Cache::delete($request->get('code'));

        return response()->json([
            'message' => __('auth.password-changed')
        ]);
    }
}
