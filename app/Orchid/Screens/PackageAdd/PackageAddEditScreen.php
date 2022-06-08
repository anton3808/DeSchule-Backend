<?php

namespace App\Orchid\Screens\PackageAdd;

use App\Orchid\View\Components\PackageAddElement\PackageAddElementComponent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Package\Package;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Support\Facades\Toast;

class PackageAddEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'PackageAddEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    /**
     * Query data.
     *
     * @param Package $package
     * @return array
     */
    public function query(Package $package): array
    {
        $this->exists = $package->exists;

        if ($this->exists) {
            $this->name = __('orchid.pages.package_add.update');
        } else {
            $this->name = __('orchid.pages.package_add.create');
        }

        return $package->getAttributes();
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
            LayoutFacade::component(PackageAddElementComponent::class)
        ];
    }

    /**
     * @param Package $package
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Package $package, Request $request): RedirectResponse
    {
        $request->validate([
            'image'            => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'price' => ['nullable', 'numeric', 'min:1'],
            'title.*'         => 'string',
            'description.*'   => 'string',
        ]);

        foreach (config('locales') as $locale) {
            $package->translateOrNew($locale)->title = $request->get('title')[$locale];
            $package->translateOrNew($locale)->description = $request->get('description')[$locale];
        }

        $package->fill($request->only(['type', 'status', 'image', 'price']) + ['type' => 'additional']);

        $package->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.packages_add.edit', ['package' => $package->id]);
    }

    /**
     * @param Package $package
     * @return RedirectResponse
     */
    public function remove(Package $package): RedirectResponse
    {
        $package->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.packages_add.index');
    }
}
