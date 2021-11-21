<?php

namespace App\Orchid\Screens\Study;

use App\Orchid\Controllers\Study\LessonElementDataController;
use App\Orchid\View\Components\LessonElement\LessonElementComponent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Study\Entities\LessonElement;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Support\Facades\Toast;

class LessonElementEditScreen extends Screen
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
        return [
            LayoutFacade::component(LessonElementComponent::class)
        ];
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
