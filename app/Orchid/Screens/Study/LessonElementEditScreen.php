<?php

namespace App\Orchid\Screens\Study;

use App\Orchid\Controllers\Study\LessonElementDataController;
use App\Orchid\Screens\Extended\ExtendedVueScreen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Study\Entities\LessonElement;
use Modules\Study\Entities\LessonElementType;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Support\Facades\Toast;

class LessonElementEditScreen extends ExtendedVueScreen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'LessonElementEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    private ?LessonElement $lessonElement;

    /**
     * Query data.
     *
     * @param LessonElement $lessonElement
     * @return array
     */
    public function query(LessonElement $lessonElement): array
    {
        $this->exists = $lessonElement->exists;

        if ($this->exists) {
            $this->lessonElement = $lessonElement;
            $this->name = __('orchid.pages.lesson_elements.update');
        } else {
            $this->name = __('orchid.pages.lesson_elements.create');
        }

        return $lessonElement->getAttributes();
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        'study.lessons'
    ];

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('orchid.links.create'))
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
            Button::make(__('orchid.links.update'))
                ->icon('save')
                ->method('createOrUpdate')
                ->canSee($this->exists),
            Button::make(__('orchid.links.delete'))
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists)];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     * @throws \Throwable
     */
    public function layout(): array
    {
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
        $rows = [
            LayoutFacade::rows([
                Group::make(array_splice($inputs, 0, 2)),
                Group::make($inputs),
                Group::make([
                    Cropper::make('icon')
                        ->title(__('orchid.models.lesson_elements.icon'))
                        ->placeholder(__('orchid.models.lesson_elements.icon'))
                        ->storage('study'),
                    Select::make('element_type_id')
                        ->fromQuery(LessonElementType::query(), 'title', 'id')
                        ->title(__('orchid.models.lesson_elements.element_type'))
                        ->id('lesson-element-type-select')
                ])
            ])
        ];
        array_push($rows, LayoutFacade::view('orchid.models.LessonElement.data', [
            'url' => route('platform.study.lesson_elements.data-view'),
            'id'  => $this->exists ? $this->lessonElement->id : null
        ]));
        return $rows;
    }

    /**
     * @param LessonElement $lessonElement
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(LessonElement $lessonElement, Request $request): RedirectResponse
    {
        $request->validate([
            'icon'            => ['nullable', 'string'],
            'element_type_id' => ['required', 'numeric', 'exists:lesson_element_types,id'],
            'title.*'         => 'string',
            'description.*'   => 'string',
        ]);

        foreach (config('locales') as $locale) {
            $lessonElement->translateOrNew($locale)->title = $request->get('title')[$locale];
            $lessonElement->translateOrNew($locale)->description = $request->get('description')[$locale];
        }

        $lessonElement->fill($request->only(['element_type_id', 'icon']));

        $lessonElement->save();

        LessonElementDataController::SaveLessonElementData($lessonElement->id, $request->get('data'), $request->file('data'));

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.study.lesson_elements.edit', ['lesson_element' => $lessonElement->id]);
    }

    /**
     * @param LessonElement $lessonElement
     * @return RedirectResponse
     */
    public function remove(LessonElement $lessonElement): RedirectResponse
    {
        $lessonElement->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.study.lesson_elements.index');
    }
}
