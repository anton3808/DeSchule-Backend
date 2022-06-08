<?php

namespace App\Orchid\Screens\Challenge;

use App\Models\Challenge\Character;
use App\Orchid\Layouts\Tables\CharacterListLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class CharacterScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'CharacterScreen';

    public function __construct()
    {
        $this->name = 'Персонажи';
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'characters' => Character::paginate()
        ];
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        //'platform.characters'
    ];

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make(__('orchid.links.create'))
                ->icon('pencil')
                ->route('platform.characters.edit')
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            CharacterListLayout::class
        ];
    }
}
