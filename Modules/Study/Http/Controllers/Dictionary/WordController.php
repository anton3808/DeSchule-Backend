<?php

namespace Modules\Study\Http\Controllers\Dictionary;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Study\Entities\Dictionary\Word;
use Modules\Study\Transformers\Dictionary\Word\WordResource;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return WordResource::collection(Word::paginate($request->get('per_page', 15)));
    }

//    /**
//     * Store a newly created resource in storage.
//     * @param Request $request
//     * @return Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }
//
//    /**
//     * Show the specified resource.
//     * @param int $id
//     * @return Response
//     */
//    public function show($id)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     * @param Request $request
//     * @param int $id
//     * @return Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     * @param int $id
//     * @return Response
//     */
//    public function destroy($id)
//    {
//        //
//    }
}
