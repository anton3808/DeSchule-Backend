<?php

namespace Modules\Study\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Study\Entities\Lesson;
use Modules\Study\Http\Requests\Lesson\CreateLessonRequest;
use Modules\Study\Http\Requests\Lesson\UpdateLessonRequest;
use Modules\Study\Transformers\Lesson\LessonResource;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return LessonResource::collection(Lesson::paginate($request->get('per_page', 15)));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateLessonRequest $request
     * @return LessonResource
     */
    public function store(CreateLessonRequest $request): LessonResource
    {
        $lesson = new Lesson();
        $lesson->fill($request->model());
        foreach (config('locales') as $locale) {
            $lesson->translateOrNew($locale)->title = $request->translatable()[$locale];
        }
        $lesson->save();

        return LessonResource::make($lesson);
    }

    /**
     * Show the specified resource.
     * @param Lesson $lesson
     * @return LessonResource
     */
    public function show(Lesson $lesson): LessonResource
    {
        return LessonResource::make($lesson);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateLessonRequest $request
     * @param Lesson $lesson
     * @return LessonResource
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson): LessonResource
    {
        $lesson->fill($request->model());
        foreach (config('locales') as $locale) {
            $lesson->translateOrNew($locale)->title = $request->translatable()[$locale];
        }
        $lesson->save();
        return LessonResource::make($lesson);
    }

    /**
     * Remove the specified resource from storage.
     * @param Lesson $lesson
     * @return JsonResponse
     */
    public function destroy(Lesson $lesson): JsonResponse
    {
        $lesson->delete();
        return response()->json($lesson->id);
    }
}
