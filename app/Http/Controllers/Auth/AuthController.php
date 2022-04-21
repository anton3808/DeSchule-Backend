<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Exception;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Models\User;

class AuthController extends Controller
{
    protected $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function register(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }

        $request->merge(['password' => bcrypt($request->password)]);
        try{
            $this->user->create($request->all());
            return response()->json([
                "status" => "success",
                "message" => "успішно зареєстровано"
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                "error" => "could_not_register",
                "message" => "Неможливо зареєструвати користувача"
            ], 400);
        }
    }

    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('login', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json([
                    "error" => "invalid_credentials",
                    "message" => "Облікові дані користувача були неправильними."
                ], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                "error" => "could_not_create_token",
                "message" => "Увімкнути обробку запиту."
            ], 422);
        }

        // all good so return the token
        $user =  $this->user->where('login', $request->get('login'))->get();
        return response()->json([
            'user'  => $user,
            'token' => $token,
        ],200);
    }

    public function refreshToken()
    {
        $token = auth('api')->getToken();

        try {
            $token = auth('api')->refresh($token);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'could_not_create_token',
                "message" => "Увімкнути обробку запиту."
            ], 500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Вийшов успішно']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}
