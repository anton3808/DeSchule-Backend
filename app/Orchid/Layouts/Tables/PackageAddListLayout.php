<?php

namespace App\Orchid\Layouts\Tables;

use App\Models\Package\Package;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PackageAddListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'packages';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title', __('orchid.models.package.title')),
            TD::make('price', __('orchid.models.package.price')),
            TD::make('type', __('orchid.models.package.type')),
            TD::make('status', __('orchid.models.package.status')),
            TD::make('updated_at', __('orchid.models.default.updated_at'))
                ->render(function (Package $package) {
                    return $package->updated_at->format('d.m.Y H:i:s');
                }),
            TD::make()
                ->render(function (Package $package) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.packages_add.edit', ['package' => $package->id]);
                })
        ];
    }
}
