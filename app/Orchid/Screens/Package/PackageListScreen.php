<?php

namespace App\Orchid\Screens\Package;

use App\Orchid\Layouts\Tables\PackageListLayout;
use App\Models\Package\Package;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class PackageListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Packages';

    public function __construct()
    {
        $this->name = __('orchid.pages.package.index');
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'packages' => Package::paginate(),
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
                ->route('platform.packages.edit')
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
            PackageListLayout::class
        ];
    }
}
