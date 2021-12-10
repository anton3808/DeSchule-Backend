<?php

namespace App\Orchid\Screens\User;

use App\Orchid\Layouts\Tables\ScheduleEventTypesLayout;
use Modules\User\Entities\Schedule\ScheduleEventType;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class ScheduleEventTypesListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'ScheduleEventTypesListScreen';

    public function __construct()
    {
        $this->name = __('orchid.pages.event_types.index');
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'event_types' => ScheduleEventType::paginate()
        ];
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        'schedule.event_types'
    ];

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            ScheduleEventTypesLayout::class
        ];
    }
}
