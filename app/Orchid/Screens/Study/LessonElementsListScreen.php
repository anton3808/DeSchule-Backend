<?php

namespace App\Orchid\Screens\Study;

use App\Orchid\Layouts\Tables\LessonElementsListLayout;
use Modules\Study\Entities\LessonElement;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class LessonElementsListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'LessonElementsListScreen';

    public function __construct()
    {
        $this->name = __('orchid.pages.lesson_elements.index');
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'lesson_elements' => LessonElement::paginate()
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
            Link::make(__('orchid.links.create'))
                ->icon('pencil')
                ->route('platform.study.lesson_elements.edit')
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
            LessonElementsListLayout::class
        ];
    }
}
