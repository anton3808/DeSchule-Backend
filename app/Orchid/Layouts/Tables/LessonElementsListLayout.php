<?php

namespace App\Orchid\Layouts\Tables;

use Modules\Study\Entities\LessonElement;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LessonElementsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'lesson_elements';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title', __('orchid.models.lesson_elements.title')),
            TD::make('element_type', __('orchid.models.lesson_elements.element_type'))
                ->render(function (LessonElement $lessonElement) {
                    return Link::make($lessonElement->elementType->title)
                        ->route('platform.study.lesson_element_types.edit', ['lesson_element_type' => $lessonElement->elementType->id]);
                }),
            TD::make()
                ->render(function (LessonElement $lessonElement) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.study.lesson_elements.edit', ['lesson_element' => $lessonElement->id]);
                })
        ];
    }
}
