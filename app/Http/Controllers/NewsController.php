<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\NewsResource;

use App\Models\News\News;

class NewsController extends Controller
{
    protected $news;

    public function __construct(News $news){
        $this->news = $news;
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
        \App::setLocale($lang);

        $news = $this->news->with('comments.replies');
        $news = $news->where('status', 'active');

        $news = $news->paginate($request->get('limit', 15));

        return NewsResource::collection($news);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        \App::setLocale($lang);

        $news = $this->news->with('comments.replies')->find($id);
        return NewsResource::make($news);
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
