<?php

namespace App\Orchid\Screens\News;

use App\Orchid\View\Components\NewsElement\NewsElementComponent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\News\News;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Support\Facades\Toast;

class NewsEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'NewsEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    /**
     * Query data.
     *
     * @param News $news
     * @return array
     */
    public function query(News $news): array
    {
        $this->exists = $news->exists;

        if ($this->exists) {
            $this->name = __('orchid.pages.news.update');
        } else {
            $this->name = __('orchid.pages.news.create');
        }

        return $news->getAttributes();
    }

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        //'platform.news'
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
                ->canSee($this->exists)];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     * @throws \Throwable
     */
    public function layout(): array
    {
        return [
            LayoutFacade::component(NewsElementComponent::class)
        ];
    }

    /**
     * @param News $news
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(News $news, Request $request): RedirectResponse
    {
        $request->validate([
            'image'            => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'title.*'         => 'string',
            'description.*'   => 'string',
        ]);

        foreach (config('locales') as $locale) {
            $news->translateOrNew($locale)->title = $request->get('title')[$locale];
            $news->translateOrNew($locale)->description = $request->get('description')[$locale];
        }

        $news->fill($request->only(['status', 'image']));

        $news->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.news.edit', ['news' => $news->id]);
    }

    /**
     * @param News $news
     * @return RedirectResponse
     */
    public function remove(News $news): RedirectResponse
    {
        $news->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.news.index');
    }
}
