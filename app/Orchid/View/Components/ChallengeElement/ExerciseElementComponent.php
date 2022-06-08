<?php

namespace App\Orchid\View\Components\ChallengeElement;

use App\Models\Challenge\Challenge;
use App\Models\Challenge\Character;
use Illuminate\View\Component;
use App\Models\Challenge\ChallengeExercise;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Screen\Repository;

class ExerciseElementComponent extends Component
{
    /**
     * @var ChallengeExercise $exercise
     */
    private $exercise;

    private bool $exists;

    public function __construct()
    {
        $this->exercise = request()->route()->parameter('exercise');
        $this->exists = !is_null($this->exercise) && $this->exercise->exists;
    }

    /**
     * @throws \Throwable
     */
    public function render()
    {
        $template =
            LayoutFacade::rows([
                Group::make([
                    Select::make('challenge_id')
                        ->title('Челендж')
                        ->fromModel(Challenge::class, 'id', 'id'),
                    Input::make('location')
                    ->value($this->exists ? $this->exercise->location : null)
                    ->type('text')
                    ->title('Локація')
                    ->placeholder('Локація'),
                    Input::make('main_line')
                        ->value($this->exists ? $this->exercise->main_line : null)
                        ->type('text')
                        ->title('Основна лінія')
                        ->placeholder('Основна лінія'),

                ]),
                Group::make([
                    Select::make('character_id')
                        ->title('Персонаж')
                        ->fromModel(Character::class, 'name', 'id'),
                    Input::make('content')
                        ->value($this->exists ? $this->exercise->content : null)
                        ->type('text')
                        ->title('Реплика')
                        ->placeholder('Реплика')
                ]),
                Group::make([
                    Select::make('status')
                        ->value($this->exists ? $this->exercise->status : null)
                        ->options([
                            'active'   => 'Active',
                            'inactive' => 'Inactive',
                        ])
                        ->title(__('orchid.models.package.status'))
                ]),
                Group::make([
                    Cropper::make('image')
                        ->value($this->exists ? $this->exercise->image : null)
                        ->title(__('orchid.models.package.icon'))
                        ->placeholder(__('orchid.models.package.icon'))
                        ->storage('study')
                ])
            ]);

        return $template->build(new Repository());
    }
}
