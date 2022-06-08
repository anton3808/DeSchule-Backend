<?php

namespace App\Orchid\Layouts\Tables;

use App\Models\Challenge\Challenge;
use App\Models\News\News;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ChallengeListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'challenges';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('order', 'Порядок'),
            TD::make('dt', 'DT'),
            TD::make('level_id', 'Рівень')
                ->render(function (Challenge $challenge) {
                    $can = request()->user()->hasAccess('study.levels');
                    return $can
                        ? Link::make($challenge->level->id)
                            ->route('platform.study.levels.edit', ['challenge' => $challenge->level->id])
                        : $challenge->level->id;
                }),
            TD::make('status', __('orchid.models.package.status')),
            TD::make('updated_at', __('orchid.models.default.updated_at'))
                ->render(function (Challenge $challenge) {
                    return $challenge->updated_at->format('d.m.Y H:i:s');
                }),
            TD::make()
                ->render(function (Challenge $challenge) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.challenges.edit', ['challenge' => $challenge->id]);
                })
        ];
    }
}
