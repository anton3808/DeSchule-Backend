<?php

namespace App\Orchid\Controllers\Study;

use App\Http\Controllers\Controller;
use App\Orchid\Repositories\LessonElementDataRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Study\Entities\LessonElement;
use Modules\Study\Entities\LessonElementType;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Throwable;

class LessonElementDataController extends Controller
{

    /**
     * @throws Throwable
     */
    public function __invoke(Request $request)
    {
        $lessonElement = LessonElement::findOrNew($request->get('id'));
        if (!$lessonElement->exists) {
            $lessonElement->data = [];
        }
        $elementType = LessonElementType::findOrFail($request->get('type'));
        $template = [];

        $method = ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $elementType->slug)))) . "Layout";
        if (method_exists(LessonElementDataRepository::class, $method)) {
            if ($lessonElement->exists && $lessonElement->element_type_id !== $elementType->id) {
                $lessonElement->data = [];
            }
            $template = LessonElementDataRepository::$method($lessonElement->data);
        } else {
            if ($lessonElement->exists) {
                $lessonElement->data = [];
                $lessonElement->save();
            }
        }

        if (!key_exists('component', $template)) {
            $template = LayoutFacade::rows($template);
            return view('orchid.layouts.base-layout', [
                'layouts' => $template->build(new Repository()),
            ]);
        } else {
            return response()->json($template);
        }
    }

    /**
     * @param int $lessonElementId
     * @param array|null $elements
     * @param array|null $files
     */
    public static function SaveLessonElementData(int $lessonElementId, ?array $elements, ?array $files)
    {
        $lessonElement = LessonElement::findOrFail($lessonElementId);
        $data = $lessonElement->data ?? [];
        if ($elements) {
            foreach ($data as $key => $value) {
                if (!array_key_exists($key, $elements)) {
                    unset($data[$key]);
                }
            }
            foreach ($elements as $key => $value) {
                $data[$key] = $value;
            }
        }
        if ($files) {
            /** @var UploadedFile $file */
            foreach ($files as $key => $file) {
                $path = Storage::disk('study')->putFile('files', $file);
                if ($path) {
                    $data[$key] = Storage::disk('study')->url($path);
                }
            }
        }
        $lessonElement->data = $data;
        $lessonElement->save();
    }
}
