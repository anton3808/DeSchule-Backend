<?php

namespace App\Orchid\Screens\Study;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Study\Entities\LessonElementType;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Support\Facades\Toast;

class LessonElementTypeEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'LessonElementTypeEditScreen';
    private LessonElementType $lessonElementType;

    /**
     * Query data.
     *
     * @param LessonElementType $lessonElementType
     * @return array
     */
    public function query(LessonElementType $lessonElementType): array
    {
        $this->name = __('orchid.pages.lesson_element_types.update');

        $this->lessonElementType = $lessonElementType;
        return $lessonElementType->getAttributes();
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
            Button::make(__('orchid.links.update'))
                ->icon('save')
                ->method('update')
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     */
    public function layout(): array
    {
        $inputs = [];
        foreach (config('locales') as $locale) {
            $input = Input::make("title.$locale")
                ->title(__('orchid.models.lesson_element_types.title') . " ($locale)")
                ->required()
                ->placeholder(__('orchid.models.lesson_element_types.title'))
                ->value($this->lessonElementType->getTranslation($locale)->title);
            array_push($inputs, $input);

            $input = Input::make("description.$locale")
                ->title(__('orchid.models.lesson_element_types.description') . " ($locale)")
                ->required()
                ->placeholder(__('orchid.models.lesson_element_types.description'))
                ->value($this->lessonElementType->getTranslation($locale)->description);
            array_push($inputs, $input);
        }
        return [
            LayoutFacade::rows([
                Group::make(array_splice($inputs, 0, 2)),
                Group::make(array_splice($inputs, 0))
            ])
        ];
    }

    public function update(LessonElementType $lessonElementType, Request $request): RedirectResponse
    {
        $request->validate([
            'title.*'       => 'string',
            'description.*' => 'string',
        ]);

        foreach (config('locales') as $locale) {
            $lessonElementType->translateOrNew($locale)->title = $request->get('title')[$locale];
            $lessonElementType->translateOrNew($locale)->description = $request->get('description')[$locale];
        }

        $lessonElementType->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.study.lesson_element_types.edit', ['lesson_element_type' => $lessonElementType->id]);
    }
}
