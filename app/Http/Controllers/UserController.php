<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Mockery\Exception;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index()
    {
        return $this->user->all();
    }

    public function show($id)
    {
        return $this->user->find($id);
    }

    public function update(Request $request, $id)
    {
        try{
            $this->user->find($id)->update($request->all());
            $data = $this->user->find($id);
            return response()->json([
                "status" => "success",
                "message" => "успішно оновлено",
                "data" => $data
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                "error" => "could_not_edit",
                "message" => $e->getMessage()
            ], 400);
        }
    }


    public function destroy($id)
    {
        $data = $this->user->find($id);
        $data->delete();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }
}
