<?php

namespace App\Orchid\Layouts\Tables;

use Modules\Study\Entities\Lesson;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LessonsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'lessons';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('order', __('orchid.models.lesson.order'))->sort(),
            TD::make('title', __('orchid.models.lesson.title')),
            TD::make('level_id', __('orchid.models.lesson.level'))
                ->render(function (Lesson $lesson) {
                    $can = request()->user()->hasAccess('study.levels');
                    return $can
                        ? Link::make($lesson->level->code)
                            ->route('platform.study.levels.edit', ['level' => $lesson->level->id])
                        : $lesson->level->code;
                })
                ->sort(),
            TD::make('updated_at', __('orchid.models.default.updated_at'))
                ->render(function (Lesson $lesson) {
                    return $lesson->updated_at->format('d.m.Y H:i:s');
                })
                ->sort(),
            TD::make()
                ->render(function (Lesson $lesson) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.study.lessons.edit', ['lesson' => $lesson->id]);
                })
        ];
    }
}
