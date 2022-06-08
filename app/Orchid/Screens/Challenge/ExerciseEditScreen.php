<?php

namespace App\Orchid\Screens\Challenge;

use App\Orchid\View\Components\ChallengeElement\ExerciseElementComponent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Challenge\ChallengeExercise;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Support\Facades\Toast;

class ExerciseEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'PackageEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    /**
     * Query data.
     *
     * @param ChallengeExercise $exercise
     * @return array
     */
    public function query(ChallengeExercise $exercise): array
    {
        $this->exists = $exercise->exists;

        if ($this->exists) {
            $this->name = __('orchid.pages.package.update');
        } else {
            $this->name = __('orchid.pages.package.create');
        }

        return $exercise->getAttributes();
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        //'platform.packages'
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
            LayoutFacade::component(ExerciseElementComponent::class)
        ];
    }

    /**
     * @param ChallengeExercise $exercise
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(ChallengeExercise $exercise, Request $request): RedirectResponse
    {
        $request->validate([
            'image'            => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'challenge_id' => ['required'],
            'location' => ['required','string'],
            'main_line' => ['required','string'],
            'character_id' => ['required'],
            'content' => ['required','string'],
        ]);

        $exercise->fill($request->only(['image', 'status', 'challenge_id', 'location', 'main_line', 'character_id', 'content']));

        $exercise->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.exercises.edit', ['exercise' => $exercise->id]);
    }

    /**
     * @param ChallengeExercise $exercise
     * @return RedirectResponse
     */
    public function remove(ChallengeExercise $exercise): RedirectResponse
    {
        $exercise->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.exercises.index');
    }
}
