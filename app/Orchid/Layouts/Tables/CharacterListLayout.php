<?php

namespace App\Orchid\Layouts\Tables;

use App\Models\Challenge\Character;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CharacterListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'characters';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('name', 'Найменування')
                ->render(function (Character $сharacter) {
                    return $сharacter->name;
                }),
            TD::make()
                ->render(function (Character $сharacter) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.characters.edit', ['character' => $сharacter->id]);
                })
        ];
    }
}
