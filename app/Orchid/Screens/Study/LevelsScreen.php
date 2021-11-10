<?php

namespace App\Orchid\Screens\Study;

use App\Orchid\Layouts\Tables\LevelsListLayout;
use Modules\Study\Entities\Level;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class LevelsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'LevelsScreen';

    public function __construct()
    {
        $this->name = __('orchid.pages.level.index');
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'levels' => Level::paginate(),
        ];
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
            Link::make(__('orchid.links.create'))
                ->icon('pencil')
                ->route('platform.study.levels.edit')
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
            LevelsListLayout::class
        ];
    }
}
