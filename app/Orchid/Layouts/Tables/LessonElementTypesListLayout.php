<?php

namespace App\Orchid\Layouts\Tables;

use Modules\Study\Entities\LessonElementType;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LessonElementTypesListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'lesson_element_types';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title', __('orchid.models.lesson_element_types.title')),
            TD::make('description', __('orchid.models.lesson_element_types.description')),
            TD::make()
                ->render(function (LessonElementType $lessonElementType) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.study.lesson_element_types.edit', ['lesson_element_type' => $lessonElementType->id]);
                })
        ];
    }
}
