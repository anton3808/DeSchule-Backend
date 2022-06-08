<?php

namespace App\Orchid\Screens\Comment;

use App\Orchid\Layouts\Tables\CommentListLayout;
use App\Models\News\NewsComment;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class CommentScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'CommentScreen';

    public function __construct()
    {
        $this->name = 'Коментарі';
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'comments' => NewsComment::paginate()
        ];
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        //'platform.payments'
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
                ->route('platform.comments.edit')
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
            CommentListLayout::class
        ];
    }
}
