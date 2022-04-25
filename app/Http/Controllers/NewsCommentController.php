<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;

use App\Models\News\NewsComment;

class NewsCommentController extends Controller
{
    protected $newsComment;

    public function __construct(NewsComment $newsComment){
        $this->newsComment = $newsComment;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = $request->header('Language', 'uk');
        $user = auth('api')->user();
        \App::setLocale($lang);

        $newsComment = $this->newsComment->with('news', 'replies')->where('user_id', $user->id);
        $newsComment = $newsComment->where('status', 'active');

        $newsComment = $newsComment->paginate($request->get('limit', 15));

        return $newsComment;
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
            $newsComment = $this->newsComment->create($data);

            return response()->json([
                "status" => "success",
                "message" => "успішно створено",
                "data" => $newsComment
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
        $lang = $request->header('Language', 'uk');
        $user = auth('api')->user();
        \App::setLocale($lang);

        $newsComment = $this->newsComment->with('news', 'replies')->where('user_id', $user->id)->find($id);
        return $newsComment;
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
