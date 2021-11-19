<?php

namespace App\Orchid\Layouts\Tables;

use Modules\Study\Entities\Dictionary\Word;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class WordsListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'words';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('word', __('orchid.models.word.word')),
            TD::make('description', __('orchid.models.word.description')),
            TD::make('updated_at', __('orchid.models.default.updated_at'))
                ->render(function (Word $word) {
                    return $word->updated_at->format('d.m.Y H:s:i');
                })
                ->sort(),
            TD::make()
                ->render(function (Word $word) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.study.dictionary.words.edit', ['word' => $word->id]);
                })
        ];
    }
}
