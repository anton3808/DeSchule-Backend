<?php

namespace App\Orchid\View\Components\ChallengeElement;

use App\Models\Challenge\Challenge;
use Illuminate\View\Component;
use Modules\Study\Entities\Level;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Screen\Repository;

class ChallengeElementComponent extends Component
{
    /**
     * @var Challenge $challenge
     */
    private $challenge;

    private bool $exists;

    public function __construct()
    {
        $this->challenge = request()->route()->parameter('challenge');
        $this->exists = !is_null($this->challenge) && $this->challenge->exists;
    }

    /**
     * @throws \Throwable
     */
    public function render()
    {
        $typeSelectId = 'lesson-element-type-select';
        $inputs = [];
        foreach (config('locales') as $locale) {
            $input = Input::make("title.$locale")
                ->title(__('orchid.models.package.title') . " ($locale)")
                ->required()
                ->placeholder(__('orchid.models.package.title'));
            if ($this->exists) {
                $input->value($this->challenge->getTranslation($locale)->title);
            }
            array_push($inputs, $input);

            //$input = Quill::make("description.$locale")->title(__('orchid.models.package.description'))->placeholder(__('orchid.models.package.description'));
//            $input = Input::make("description.$locale")
//                ->title(__('orchid.models.package.description') . " ($locale)")
//                ->required()
//                ->placeholder(__('orchid.models.package.description'));
//            if ($this->exists) {
//                $input->value($this->news->getTranslation($locale)->description);
//            }
//            array_push($inputs, $input);
        }
        $template =
            LayoutFacade::rows([
                Group::make(array_splice($inputs, 0, 2)),
                Group::make($inputs),
                Group::make([ Input::make('order')
                    ->value($this->exists ? $this->challenge->order : null)
                    ->type('number')
                    ->title('Порядок')
                    ->placeholder('Порядок'),
                    Input::make('dt')
                        ->value($this->exists ? $this->challenge->dt : null)
                        ->type('number')
                        ->title('DT')
                        ->placeholder('DT'),
                    Select::make('level_id')
                        ->title('Рівень')
                        ->fromModel(Level::class, 'id', 'id'),
                ]),
                Group::make([
                    Select::make('status')
                        ->value($this->exists ? $this->challenge->status : null)
                        ->options([
                            'active'   => 'Active',
                            'inactive' => 'Inactive',
                        ])
                        ->title(__('orchid.models.package.status'))
                ])
            ]);

        return $template->build(new Repository());
    }
}
