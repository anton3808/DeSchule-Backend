<?php

namespace App\Orchid\View\Components\PackageElement;

use Illuminate\View\Component;
use App\Models\Package\Package;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Screen\Repository;

class PackageElementComponent extends Component
{
    /**
     * @var Package $package
     */
    private $package;

    private bool $exists;

    public function __construct()
    {
        $this->package = request()->route()->parameter('package');
        $this->exists = !is_null($this->package) && $this->package->exists;
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
                $input->value($this->package->getTranslation($locale)->title);
            }
            array_push($inputs, $input);

            $input = Quill::make("description.$locale")->title(__('orchid.models.package.description'))->placeholder(__('orchid.models.package.description'));
            if ($this->exists) {
                $input->value($this->package->getTranslation($locale)->description);
            }
            array_push($inputs, $input);
        }
        $template =
            LayoutFacade::rows([
                Group::make(array_splice($inputs, 0, 2)),
                Group::make($inputs),
                Group::make([ Input::make('price')
                    ->value($this->exists ? $this->package->price : null)
                    ->type('number')
                    ->title(__('orchid.models.package.price'))
                    ->placeholder(__('orchid.models.package.price')),
                    Select::make('type')
                        ->value($this->exists ? $this->package->type : null)
                        ->options([
                            'additional'   => 'Additional',
                            'main' => 'Main',
                        ])
                        ->title(__('orchid.models.package.type')),
                    Select::make('status')
                        ->value($this->exists ? $this->package->status : null)
                        ->options([
                            'active'   => 'Active',
                            'inactive' => 'Inactive',
                        ])
                        ->title(__('orchid.models.package.status'))
                ]),
                Group::make([
                    Cropper::make('image')
                        ->value($this->exists ? $this->package->image : null)
                        ->title(__('orchid.models.package.icon'))
                        ->placeholder(__('orchid.models.package.icon'))
                        ->storage('study')
                ])
            ]);

        return $template->build(new Repository());
    }
}
