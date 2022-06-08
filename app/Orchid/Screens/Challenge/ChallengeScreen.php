<?php

namespace App\Orchid\Screens\Challenge;

use App\Models\Challenge\Challenge;
use App\Orchid\Layouts\Tables\ChallengeListLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class ChallengeScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Сhallenges';

    public function __construct()
    {
        $this->name = 'Челенджи';
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'challenges' => Challenge::paginate(),
        ];
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
            Link::make(__('orchid.links.create'))
                ->icon('pencil')
                ->route('platform.challenges.edit')
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
            ChallengeListLayout::class
        ];
    }
}
