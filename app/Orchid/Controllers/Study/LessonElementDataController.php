<?php


namespace App\Orchid\Controllers\Study;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Study\Entities\Dictionary\Word;
use Modules\Study\Entities\LessonElement;
use Modules\Study\Entities\LessonElementType;
use Modules\Study\Transformers\Dictionary\Word\WordResource;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
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

        $method = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $elementType->slug)))) . "Layout";
        if (method_exists($this, $method)) {
            if ($lessonElement->exists && $lessonElement->element_type_id !== $elementType->id) {
                $lessonElement->data = [];
            }
            $template = $this->$method($lessonElement->data);
        } else {
            if ($lessonElement->exists) {
                $lessonElement->data = null;
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

    private function readAndTranslateLayout(?array $data = []): array
    {
        $videoLayout = [];
        if (array_key_exists('video', $data)) {
            array_push($videoLayout, Link::make(__('orchid.models.lesson_element_types.previously_video'))->href($data['video']));
        }
        array_push($videoLayout,
            Input::make('data.video')
                ->type('file')
                ->title(__('orchid.models.lesson_element_types.video'))
                ->set('accept', 'video/*')
                ->class('form-control mw-100')
        );
        return [
            Quill::make("data.text")
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format'])
                ->set('rows', 10)
                ->value(array_key_exists('text', $data) ? $data['text'] : '')
                ->title(__('orchid.models.lesson_element_types.text'))
                ->required()
                ->class('form-control mw-100'),
            Group::make([
                Cropper::make('data.image')
                    ->value(array_key_exists('image', $data) ? $data['image'] : null)
                    ->title(__('orchid.models.lesson_element_types.image'))
                    ->placeholder(__('orchid.models.lesson_element_types.image'))
                    ->storage('study'),
            ]),
            Group::make($videoLayout)->alignCenter()
        ];
    }

    /**
     * @throws Throwable
     */
    private function readAndInsertLayout(?array $data = null): array
    {
        return [
            'component' => 'text-insert',
            'data'      => [
                'words'          => WordResource::collection(Word::all()),
                'selected_words' => array_key_exists('words', $data) ? $data['words'] : null
            ],
            'dom'       => view('orchid.layouts.base-layout', [
                'layouts' => self::renderFieldsetLayout([
                    Quill::make("data.text")
                        ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format'])
                        ->set('rows', 10)
                        ->value(array_key_exists('text', $data) ? $data['text'] : '')
                        ->title(__('orchid.models.lesson_element_types.text'))
                        ->required()
                        ->class('form-control mw-100'),
                ])
            ])->render()
        ];
    }

    /**
     * @throws Throwable
     */
    private static function renderFieldsetLayout($elements = []): string
    {
        return view('orchid.layouts.base-layout', [
            'layouts' => LayoutFacade::rows($elements)->build(new Repository())
        ])->render();
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
