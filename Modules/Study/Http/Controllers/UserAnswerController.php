<?php

namespace Modules\Study\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Study\Entities\UserAnswers;
use Modules\Study\Http\Requests\UserAnswer\CreateUserAnswerRequest;
use Modules\Study\Services\UserAnswersProcessingService;
use Modules\Study\Transformers\UserAnswers\UserAnswersResource;

class UserAnswerController extends Controller
{
//    /**
//     * Display a listing of the resource.
//     * @return Response
//     */
//    public function index()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     * @param CreateUserAnswerRequest $request
     * @param UserAnswersProcessingService $service
     * @return UserAnswersResource
     * @throws \Exception
     */
    public function store(CreateUserAnswerRequest $request, UserAnswersProcessingService $service): UserAnswersResource
    {
        $answers = new UserAnswers($request->validated());
        $answers->data = $service->processAnswers($request->lessonElement(), $request->answers());
        $answers->save();
        return UserAnswersResource::make($answers);
    }

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
