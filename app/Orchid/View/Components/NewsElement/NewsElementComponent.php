<?php

namespace App\Orchid\View\Components\NewsElement;

use Illuminate\View\Component;
use App\Models\News\News;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Screen\Repository;

class NewsElementComponent extends Component
{
    /**
     * @var News $news
     */
    private $news;

    private bool $exists;

    public function __construct()
    {
        $this->news = request()->route()->parameter('news');
        $this->exists = !is_null($this->news) && $this->news->exists;
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
                $input->value($this->news->getTranslation($locale)->title);
            }
            array_push($inputs, $input);

            $input = Quill::make("description.$locale")->title(__('orchid.models.package.description'))->placeholder(__('orchid.models.package.description'));
//            $input = Input::make("description.$locale")
//                ->title(__('orchid.models.package.description') . " ($locale)")
//                ->required()
//                ->placeholder(__('orchid.models.package.description'));
            if ($this->exists) {
                $input->value($this->news->getTranslation($locale)->description);
            }
            array_push($inputs, $input);
        }
        $template =
            LayoutFacade::rows([
                Group::make(array_splice($inputs, 0, 2)),
                Group::make($inputs),
                Group::make([
                    Select::make('status')
                        ->value($this->exists ? $this->news->status : null)
                        ->options([
                            'active'   => 'Active',
                            'inactive' => 'Inactive',
                        ])
                        ->title(__('orchid.models.package.status'))
                ]),
                Group::make([
                    Cropper::make('image')
                        ->value($this->exists ? $this->news->image : null)
                        ->title(__('orchid.models.package.icon'))
                        ->placeholder(__('orchid.models.package.icon'))
                        ->storage('study')
                ])
            ]);

        return $template->build(new Repository());
    }
}
