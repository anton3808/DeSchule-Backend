<?php

namespace App\Orchid\Layouts\Tables;

use App\Models\Challenge\ChallengeExercise;
use App\Models\Package\Package;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ExerciseListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'exercises';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('challenge_id', 'Челендж')
                ->render(function (ChallengeExercise $exercise) {
                    $can = request()->user()->hasAccess('study.levels');
                    return $can
                        ? Link::make($exercise->challenge->id)
                            ->route('platform.challenges.edit', ['challenge' => $exercise->challenge->id])
                        : $exercise->challenge->id;
                }),
            TD::make('location', 'Локація'),
            TD::make('main_line', 'Основна лінія'),
            TD::make('character_id', 'Персонаж')
                ->render(function (ChallengeExercise $exercise) {
                    $can = request()->user()->hasAccess('study.levels');
                    return $can
                        ? Link::make($exercise->character->name)
                            ->route('platform.characters.edit', ['character' => $exercise->character->id])
                        : $exercise->character->name;
                }),
            TD::make('content', 'Репліка'),
            TD::make('status', __('orchid.models.package.status')),
            TD::make('updated_at', __('orchid.models.default.updated_at'))
                ->render(function (ChallengeExercise $exercise) {
                    return $exercise->updated_at->format('d.m.Y H:i:s');
                }),
            TD::make()
                ->render(function (ChallengeExercise $exercise) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.exercises.edit', ['exercise' => $exercise->id]);
                })
        ];
    }
}
