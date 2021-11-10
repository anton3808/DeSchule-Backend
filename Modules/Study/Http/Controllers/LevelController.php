<?php

namespace Modules\Study\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Study\Entities\Level;
use Modules\Study\Http\Requests\Level\CreateLevelRequest;
use Modules\Study\Http\Requests\Level\UpdateLevelRequest;
use Modules\Study\Transformers\Level\LevelResource;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return LevelResource::collection(Level::paginate($request->get('per_page', 15)));
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateLevelRequest $request
     * @return LevelResource
     */
    public function store(CreateLevelRequest $request): LevelResource
    {
        $level = new Level();
        $level->fill($request->model());
        foreach (config('locales') as $locale) {
            $level->translateOrNew($locale)->title = $request->translatable()[$locale];
        }
        $level->save();
        return LevelResource::make($level);
    }

    /**
     * Show the specified resource.
     * @param Level $level
     * @return LevelResource
     */
    public function show(Level $level): LevelResource
    {
        return LevelResource::make($level);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateLevelRequest $request
     * @param Level $level
     * @return LevelResource
     */
    public function update(UpdateLevelRequest $request, Level $level): LevelResource
    {
        $level->fill($request->model());
        foreach (config('locales') as $locale) {
            $level->translateOrNew($locale)->title = $request->translatable()[$locale];
        }
        $level->save();
        return LevelResource::make($level);
    }

    /**
     * Remove the specified resource from storage.
     * @param Level $level
     * @return JsonResponse
     */
    public function destroy(Level $level): JsonResponse
    {
        $level->delete();
        return response()->json($level->id);
    }
}
