<?php

declare(strict_types=1);

namespace App\Orchid;

use Modules\User\Entities\User;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        /** @var User $user */
        $user = request()->user();
        return [
            Menu::make(__('orchid.menu.packages'))
                //->permission('platform.package')
                ->icon('list')
                ->route('platform.packages.index'),

            Menu::make(__('orchid.menu.program'))
                ->permission('study.*')
                ->icon('modules')
                ->list([
                    Menu::make(__('orchid.menu.levels'))
                        ->permission('study.levels')
                        ->route('platform.study.levels.index'),
                    Menu::make(__('orchid.menu.lessons'))
                        ->permission('study.lessons')
                        ->route('platform.study.lessons.index'),
                    Menu::make(__('orchid.menu.lesson_element_types'))
                        ->permission('study.lesson_element_types')
                        ->route('platform.study.lessons.lesson_element_types'),
                    Menu::make(__('orchid.menu.lesson_elements'))
                        ->permission('study.lesson_elements')
                        ->route('platform.study.lesson_elements.index'),
                ]),


            Menu::make(__('orchid.menu.dictionary.dictionary'))
                ->permission('study.dictionary')
                ->icon('book-open')
                ->list([
                    Menu::make(__('orchid.menu.dictionary.words'))
                        ->route('platform.study.dictionary.words.index'),
                ]),

            Menu::make(__('orchid.menu.schedule.schedule'))
                ->permission('schedule.*')
                ->icon('event')
                ->list([
                    Menu::make(__('orchid.menu.schedule.event_types'))
                        ->route('platform.user.schedule.event_types.index'),
                ]),

//            Menu::make('Example screen')
//                ->icon('monitor')
//                ->route('platform.example')
//                ->title('Navigation')
//                ->badge(function () {
//                    return 6;
//                }),
//
//            Menu::make('Dropdown menu')
//                ->icon('code')
//                ->list([
//                    Menu::make('Sub element item 1')->icon('bag'),
//                    Menu::make('Sub element item 2')->icon('heart'),
//                ]),
//
//            Menu::make('Basic Elements')
//                ->title('Form controls')
//                ->icon('note')
//                ->route('platform.example.fields'),
//
//            Menu::make('Advanced Elements')
//                ->icon('briefcase')
//                ->route('platform.example.advanced'),
//
//            Menu::make('Text Editors')
//                ->icon('list')
//                ->route('platform.example.editors'),
//
//            Menu::make('Overview layouts')
//                ->title('Layouts')
//                ->icon('layers')
//                ->route('platform.example.layouts'),
//
//            Menu::make('Chart tools')
//                ->icon('bar-chart')
//                ->route('platform.example.charts'),
//
//            Menu::make('Cards')
//                ->icon('grid')
//                ->route('platform.example.cards')
//                ->divider(),
//
//            Menu::make('Documentation')
//                ->title('Docs')
//                ->icon('docs')
//                ->url('https://orchid.software/en/docs'),
//
//            Menu::make('Changelog')
//                ->icon('shuffle')
//                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
//                ->target('_blank')
//                ->badge(function () {
//                    return Dashboard::version();
//                }, Color::DARK()),
//
            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group(__('orchid.roles.study'))
                ->addPermission('study.levels', __('orchid.permissions.levels'))
                ->addPermission('study.lessons', __('orchid.permissions.lessons'))
                ->addPermission('study.lesson_element_types', __('orchid.permissions.lesson_element_types'))
                ->addPermission('study.lesson_elements', __('orchid.permissions.lesson_elements'))
                ->addPermission('study.dictionary', __('orchid.permissions.dictionary')),
            ItemPermission::group(__('orchid.roles.schedule'))
                ->addPermission('schedule.event_types', __('orchid.permissions.event_types'))
        ];
    }
}
