<?php

namespace App\Orchid\Screens\Challenge;

use App\Orchid\View\Components\ChallengeElement\ChallengeElementComponent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Challenge\Challenge;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Support\Facades\Toast;

class ChallengeEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'ChallengeEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    /**
     * Query data.
     *
     * @param Challenge $challenge
     * @return array
     */
    public function query(Challenge $challenge): array
    {
        $this->exists = $challenge->exists;

        if ($this->exists) {
            $this->name = 'Редагування Челенджу';
        } else {
            $this->name = 'Створення Челенджу';
        }

        return $challenge->getAttributes();
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        //'platform.news'
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
            LayoutFacade::component(ChallengeElementComponent::class)
        ];
    }

    /**
     * @param Challenge $challenge
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Challenge $challenge, Request $request): RedirectResponse
    {
        $request->validate([
            'order'            => ['required', 'string'],
            'level_id'      => ['required', 'string'],
            'dt'            => ['required', 'string'],
            'status' => ['required', 'string'],
            'title.*'         => 'string',
        ]);

        foreach (config('locales') as $locale) {
            $challenge->translateOrNew($locale)->title = $request->get('title')[$locale];
        }

        $challenge->fill($request->only(['order', 'level_id', 'dt', 'status']));

        $challenge->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.challenges.edit', ['challenge' => $challenge->id]);
    }

    /**
     * @param Challenge $challenge
     * @return RedirectResponse
     */
    public function remove(Challenge $challenge): RedirectResponse
    {
        $challenge->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.challenges.index');
    }
}
