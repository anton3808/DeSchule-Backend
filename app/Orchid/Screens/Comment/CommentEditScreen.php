<?php

namespace App\Orchid\Screens\Comment;

use App\Models\News\News;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;

use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Toast;

use App\Models\News\NewsComment;
use App\Models\User;
use App\Models\Package\Package;

class CommentEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'CommentEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    private ?NewsComment $comment;

    /**
     * Query data.
     *
     * @param NewsComment $comment
     * @return array
     */
    public function query(NewsComment $comment): array
    {
        $this->exists = $comment->exists;

        if ($this->exists) {
            $this->payment = $comment;
            $this->name = 'Редагування Коментарі';
        } else {
            $this->name = 'Створення Коментар';
        }

        return $comment->getAttributes();
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
            Button::make(__('orchid.links.create'))
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
            Button::make(__('orchid.links.update'))
                ->icon('save')
                ->method('createOrUpdate')
                ->canSee($this->exists),
            Button::make(__('orchid.links.delete'))
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists)
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     * @throws BindingResolutionException
     */
    public function layout(): array
    {
        return [
            LayoutFacade::rows([
                Group::make([
                    Select::make('user_id')
                        ->title(__('orchid.models.payment.user_id'))
                        ->fromModel(User::class, 'name', 'id'),
                    Select::make('news_id')
                        ->title('Новина')
                        ->fromModel(News::class, 'id', 'id')
                ]),
                Group::make([
                    Input::make('content')
                        ->type('text')
                        ->title('Відгук')
                        ->placeholder('Відгук'),
                ]),
            ])
        ];
    }

    /**
     * @param NewsComment $comment
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(NewsComment $comment, Request $request): RedirectResponse
    {
        $request->validate([
            'content'    => ['required', 'min:1'],
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'news_id' => ['required', 'numeric', 'exists:news,id'],
        ]);

        $comment->fill($request->only(['content', 'user_id', 'news_id']));

        $comment->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.comments.edit', ['comment' => $comment->id]);
    }

    /**
     * @param NewsComment $comment
     * @return RedirectResponse
     */
    public function remove(NewsComment $comment): RedirectResponse
    {
        $comment->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.comments.index');
    }
}
