<?php

namespace App\Orchid\Screens\PackageAdd;

use App\Orchid\Layouts\Tables\PackageAddListLayout;
use App\Models\Package\Package;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class PackageAddListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'PackagesAdd';

    public function __construct()
    {
        $this->name = __('orchid.pages.package_add.index');
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'packages' => Package::where('type', 'additional')->paginate(),
        ];
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        //'platform.packages'
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
                ->route('platform.packages_add.edit')
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
            PackageAddListLayout::class
        ];
    }
}
