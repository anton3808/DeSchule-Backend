<?php

namespace App\Orchid\Layouts\Tables;

use App\Models\News\NewsComment;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CommentListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'comments';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('user_id', __('orchid.models.payment.user_id'))
                ->render(function (NewsComment $comment) {
                    $can = request()->user()->hasAccess('study.levels');
                    return $can
                        ? Link::make($comment->user->name)
                            ->route('platform.payments.edit', ['user' => $comment->user->id])
                        : $comment->user->name;
                }),
            TD::make('news_id', 'Новина')
                ->render(function (NewsComment $comment) {
                    $can = request()->user()->hasAccess('study.levels');
                    return $can
                        ? Link::make($comment->news->id)
                            ->route('platform.news.edit', ['news' => $comment->news->id])
                        : $comment->news->id;
                }),
            TD::make('content', 'Відгук')
                ->render(function (NewsComment $comment) {
                    return $comment->content;
                }),
            TD::make('updated_at', __('orchid.models.default.updated_at'))
                ->render(function (NewsComment $comment) {
                    return $comment->updated_at->format('d.m.Y H:i:s');
                }),
            TD::make('status', __('orchid.models.payment.status'))
                ->render(function (NewsComment $comment) {
                    return $comment->status;
                }),
            TD::make()
                ->render(function (NewsComment $comment) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.comments.edit', ['comment' => $comment->id]);
                })
        ];
    }
}
