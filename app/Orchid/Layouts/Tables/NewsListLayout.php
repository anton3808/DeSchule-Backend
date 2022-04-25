<?php

namespace App\Orchid\Layouts\Tables;

use App\Models\News\News;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class NewsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'news';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('title', __('orchid.models.package.title')),
            TD::make('status', __('orchid.models.package.status')),
            TD::make('updated_at', __('orchid.models.default.updated_at'))
                ->render(function (News $news) {
                    return $news->updated_at->format('d.m.Y H:i:s');
                }),
            TD::make()
                ->render(function (News $news) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.news.edit', ['news' => $news->id]);
                })
        ];
    }
}
