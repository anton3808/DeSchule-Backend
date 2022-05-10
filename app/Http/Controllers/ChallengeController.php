<?php

namespace App\Http\Controllers;

use App\Models\Challenge\Challenge;
use App\Transformers\NewsResource;
use Illuminate\Http\Request;
use Mockery\Exception;

class ChallengeController extends Controller
{
    protected $challenge;

    public function __construct(Challenge $challenge){
        $this->challenge = $challenge;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $challenge = $this->challenge->where('user_id', auth('api')->user()->id)->with('lesson.level');

        $challenge = $challenge->paginate($request->get('limit', 15));

        return $challenge;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = $request->all();
            $user = auth('api')->user();
            $data['user_id'] = $user->id;
            $challenge = $this->challenge->create($data);

            return response()->json([
                "status" => "success",
                "message" => "успішно створено",
                "data" => $challenge
            ], 200);
        }
        catch(Exception $e){
            return response()->json([
                "error" => "could_not_create",
                "message" => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $challenge = $this->challenge->where('user_id', auth('api')->user()->id)->with('lesson.level')->find($id);
        return $challenge;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
