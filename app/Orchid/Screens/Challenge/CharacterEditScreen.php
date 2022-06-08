<?php

namespace App\Orchid\Screens\Challenge;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

use App\Models\Challenge\Character;
use App\Models\User;
use App\Models\Package\Package;

class CharacterEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'CharacterEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    private ?Character $character;

    /**
     * Query data.
     *
     * @param Character $character
     * @return array
     */
    public function query(Character $character): array
    {
        $this->exists = $character->exists;

        if ($this->exists) {
            $this->payment = $character;
            $this->name = __('orchid.pages.payment.update');
        } else {
            $this->name = __('orchid.pages.payment.create');
        }

        return $character->getAttributes();
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        //'platform.payments'
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
        return [
            LayoutFacade::rows([
                Group::make([
                    Input::make('name')
                        ->type('text')
                        ->title('Найменування')
                        ->placeholder('Найменування')
                ]),
            ])
        ];
    }

    /**
     * @param Character $character
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Character $character, Request $request): RedirectResponse
    {
        $request->validate([
            'name'    => ['required', 'min:1'],
        ]);

        $character->fill($request->only(['name']));

        $character->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.characters.edit', ['character' => $character->id]);
    }

    /**
     * @param Character $character
     * @return RedirectResponse
     */
    public function remove(Character $character): RedirectResponse
    {
        $character->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.characters.index');
    }
}
