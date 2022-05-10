<?php

namespace App\Orchid\Screens\Study;

use App\Orchid\Layouts\Tables\LessonElementTypesListLayout;
use Modules\Study\Entities\LessonElementType;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class LessonElementTypesListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'LessonElementTypesListScreen';

    public function __construct()
    {
        $this->name = __('orchid.pages.lesson_element_types.index');
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'lesson_element_types' => LessonElementType::paginate()
        ];
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        'study.lessons'
    ];

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
//            Link::make(__('orchid.links.create'))
//                ->icon('pencil')
//                ->route('platform.study.lesson_element_type.edit')
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
            LessonElementTypesListLayout::class
        ];
    }
}
