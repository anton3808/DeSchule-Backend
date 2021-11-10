<?php

namespace App\Orchid\Layouts\Tables;

use Modules\Study\Entities\Level;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LevelsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'levels';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('code', __('orchid.models.level.code')),
            TD::make('title', __('orchid.models.level.title')),
            TD::make('priority', __('orchid.models.level.priority'))->sort(),
            TD::make('updated_at', __('orchid.models.default.updated_at'))
                ->render(function (Level $level) {
                    return $level->updated_at->format('d.m.Y H:s:i');
                })
                ->sort(),
            TD::make()
                ->render(function (Level $level) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.study.levels.edit', ['level' => $level->id]);
                })
        ];
    }
}
