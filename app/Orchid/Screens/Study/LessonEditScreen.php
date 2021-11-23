<?php

namespace App\Orchid\Screens\Study;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Modules\Study\Entities\Lesson;
use Modules\Study\Entities\LessonElement;
use Modules\Study\Entities\Level;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class LessonEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'LessonEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    private ?Lesson $lesson;

    /**
     * Query data.
     *
     * @param Lesson $lesson
     * @return array
     */
    public function query(Lesson $lesson): array
    {
        $this->exists = $lesson->exists;

        if ($this->exists) {
            $this->lesson = $lesson;
            $this->name = __('orchid.pages.lesson.update');
        } else {
            $this->name = __('orchid.pages.lesson.create');
        }

        return $lesson->getAttributes();
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
                ->canSee($this->exists)
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     * @throws BindingResolutionException
     */
    public function layout(): array
    {
        $titles = [];
        foreach (config('locales') as $locale) {
            $input = Input::make("title.$locale")
                ->title(__('orchid.models.lesson.title') . " ($locale)")
                ->required()
                ->placeholder(__('orchid.models.lesson.title'));
            if ($this->exists) {
                $input->value($this->lesson->getTranslation($locale)->title);
            }
            array_push($titles, $input);
        }
        return [
            LayoutFacade::rows([
                Group::make($titles),
                Group::make([
                    Input::make('order')
                        ->type('number')
                        ->title(__('orchid.models.lesson.order'))
                        ->placeholder(__('orchid.models.lesson.order')),
                    Select::make('level_id')
                        ->title(__('orchid.models.lesson.level'))
                        ->fromModel(Level::class, 'code', 'id'),
                    Relation::make('elements.')
                        ->value($this->exists ? $this->lesson->elements : [])
                        ->title(__('orchid.models.lesson.elements'))
                        ->fromModel(LessonElement::class, 'id', 'id')
                        ->displayAppend('orchid_tag')
                        ->multiple()
                ])
            ])
        ];
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Lesson $lesson, Request $request): RedirectResponse
    {
        $request->validate([
            'order'    => ['nullable', 'numeric', 'min:1'],
            'level_id' => ['required', 'numeric', 'exists:levels,id'],
            'title.*'  => 'string',
            'elements' => ['nullable', 'array']
        ]);


        foreach (config('locales') as $locale) {
            $lesson->translateOrNew($locale)->title = $request->get('title')[$locale];
        }

        $lesson->fill($request->only(['order', 'level_id']));

        $lesson->save();

        $lesson->elements()->sync($request->get('elements'));

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.study.lessons.edit', ['lesson' => $lesson->id]);
    }

    /**
     * @param Lesson $lesson
     * @return RedirectResponse
     */
    public function remove(Lesson $lesson): RedirectResponse
    {
        $lesson->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.study.lessons.index');
    }
}
