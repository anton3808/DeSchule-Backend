<?php

namespace App\Orchid\Screens\Challenge;

use App\Models\Challenge\ChallengeExercise;
use App\Orchid\Layouts\Tables\ExerciseListLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class ExerciseScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Exercises';

    public function __construct()
    {
        $this->name = 'Діалог';
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'exercises' => ChallengeExercise::paginate(),
        ];
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        //'platform.exercises'
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
                ->route('platform.exercises.edit')
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
            ExerciseListLayout::class
        ];
    }
}
