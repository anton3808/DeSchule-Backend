<?php

namespace App\Orchid\Screens\Study;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Modules\Study\Entities\Level;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

class LevelEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'LevelEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    private ?Level $level;

    /**
     * Query data.
     *
     * @param Level $level
     * @return array
     */
    public function query(Level $level): array
    {
        $this->exists = $level->exists;

        if ($this->exists) {
            $this->level = $level;
            $this->name = __('orchid.pages.level.update');
        } else {
            $this->name = __('orchid.pages.level.create');
        }

        return $level->getAttributes();
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        'study.levels'
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
     */
    public function layout(): array
    {
        $titles = [];
        foreach (config('locales') as $locale) {
            $input = Input::make("title.$locale")
                ->title(__('orchid.models.level.title') . " ($locale)")
                ->required()
                ->placeholder(__('orchid.models.level.title'));
            if ($this->exists) {
                $input->value($this->level->getTranslation($locale)->title);
            }
            array_push($titles, $input);
        }
        return [
            LayoutFacade::rows([
                Group::make(array_merge([
                    Input::make('code')
                        ->required()
                        ->title(__('orchid.models.level.code'))
                        ->placeholder(__('orchid.models.level.code')),
                    Input::make('priority')
                        ->required()
                        ->type('number')
                        ->title(__('orchid.models.level.priority'))
                        ->placeholder(__('orchid.models.level.priority')),
                ], $titles))
            ])
        ];
    }

    public function createOrUpdate(Level $level, Request $request): RedirectResponse
    {
        $request->validate([
            'priority' => ['required', 'numeric', 'min:1', !$level->exists ? Rule::unique('levels', 'priority')->ignore($level->id) : null],
            'code'     => ['required', 'string', 'min:2', !$level->exists ? Rule::unique('levels', 'code')->ignore($level->id) : null],
            'title.*'  => 'string',
        ]);

        foreach (config('locales') as $locale) {
            $level->translateOrNew($locale)->title = $request->get('title')[$locale];
        }

        $level->fill($request->only(['priority', 'code']));

        $level->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.study.levels.edit', ['level' => $level->id]);
    }

    /**
     * @param Level $level
     * @return RedirectResponse
     */
    public function remove(Level $level): RedirectResponse
    {
        $level->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.study.levels.index');
    }
}
