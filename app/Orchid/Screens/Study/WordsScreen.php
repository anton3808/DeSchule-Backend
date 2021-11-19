<?php

namespace App\Orchid\Screens\Study;

use App\Orchid\Layouts\Tables\WordsListLayout;
use Modules\Study\Entities\Dictionary\Word;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class WordsScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'WordsScreen';

    public function __construct()
    {
        $this->name = __('orchid.pages.word.index');
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'words' => Word::paginate()
        ];
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        'study.dictionary'
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
                ->route('platform.study.dictionary.words.edit')
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
            WordsListLayout::class
        ];
    }
}
