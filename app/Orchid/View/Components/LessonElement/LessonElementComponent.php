<?php

namespace App\Orchid\View\Components\LessonElement;

use Illuminate\View\Component;
use Modules\Study\Entities\LessonElement;
use Modules\Study\Entities\LessonElementType;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Screen\Repository;

class LessonElementComponent extends Component
{
    /**
     * @var LessonElement $lessonElement
     */
    private $lessonElement;

    private bool $exists;

    public function __construct()
    {
        $this->lessonElement = request()->route()->parameter('lessonElement');
        $this->exists = $this->lessonElement->exists;
    }

    /**
     * @throws \Throwable
     */
    public function render()
    {
        $typeSelectId = 'lesson-element-type-select';
        $inputs = [];
        foreach (config('locales') as $locale) {
            $input = Input::make("title.$locale")
                ->title(__('orchid.models.lesson_element_types.title') . " ($locale)")
                ->required()
                ->placeholder(__('orchid.models.lesson_element_types.title'));
            if ($this->exists) {
                $input->value($this->lessonElement->getTranslation($locale)->title);
            }
            array_push($inputs, $input);

            $input = Input::make("description.$locale")
                ->title(__('orchid.models.lesson_element_types.description') . " ($locale)")
                ->required()
                ->placeholder(__('orchid.models.lesson_element_types.description'));
            if ($this->exists) {
                $input->value($this->lessonElement->getTranslation($locale)->description);
            }
            array_push($inputs, $input);
        }
        $template =
            LayoutFacade::rows([
                Group::make(array_splice($inputs, 0, 2)),
                Group::make($inputs),
                Group::make([
                    Cropper::make('icon')
                        ->title(__('orchid.models.lesson_elements.icon'))
                        ->placeholder(__('orchid.models.lesson_elements.icon'))
                        ->storage('study'),
                    Select::make('element_type_id')
                        ->value($this->exists ? $this->lessonElement->element_type_id : null)
                        ->fromQuery(LessonElementType::query(), 'title', 'id')
                        ->title(__('orchid.models.lesson_elements.element_type'))
                        ->id($typeSelectId)
                ])
            ]);

        return view('orchid.models.LessonElement.edit', [
            'layouts'      => $template->build(new Repository()),
            'typeSelectId' => $typeSelectId,
            'url'          => route('platform.study.lesson_elements.data-view'),
            'id'           => $this->exists ? $this->lessonElement->id : null
        ]);
    }
}
