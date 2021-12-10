<?php

namespace App\Orchid\Layouts\Tables;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ScheduleEventTypesLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'event_types';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', __('#'))->sort(),
            TD::make('title', __('orchid.models.event_types.title')),
        ];
    }
}
