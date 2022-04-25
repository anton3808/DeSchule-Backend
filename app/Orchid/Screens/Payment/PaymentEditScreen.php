<?php

namespace App\Orchid\Screens\Payment;

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

use App\Models\Payment;
use App\Models\User;
use App\Models\Package\Package;

class PaymentEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'PaymentEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    private ?Payment $payment;

    /**
     * Query data.
     *
     * @param Payment $payment
     * @return array
     */
    public function query(Payment $payment): array
    {
        $this->exists = $payment->exists;

        if ($this->exists) {
            $this->payment = $payment;
            $this->name = __('orchid.pages.payment.update');
        } else {
            $this->name = __('orchid.pages.payment.create');
        }

        return $payment->getAttributes();
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
                    Input::make('amount')
                        ->type('number')
                        ->title(__('orchid.models.payment.amount'))
                        ->placeholder(__('orchid.models.payment.amount')),
                    Select::make('amount_type')
                        ->options([
                            'money'   => 'Гроші',
                            'dt' => 'DT',
                        ])
                        ->title('Звідки оплата'),
                    DateTimer::make('active_before')
                        ->title('Дійсна до'),
                ]),
                Group::make([
                    Select::make('user_id')
                        ->title(__('orchid.models.payment.user_id'))
                        ->fromModel(User::class, 'name', 'id'),
                    Select::make('package_id')
                        ->title(__('orchid.models.payment.package_id'))
                        ->fromModel(Package::class, 'id', 'id'),
                    Select::make('status')
                        ->options([
                            'pending'   => 'Очікуваний',
                            'paid' => 'Оплачено',
                            'rejected' => 'Відхилено',
                        ])
                        ->title(__('orchid.models.payment.status')),
                ]),
            ])
        ];
    }

    /**
     * @param Payment $payment
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Payment $payment, Request $request): RedirectResponse
    {
        $request->validate([
            'amount'    => ['required', 'numeric', 'min:1'],
            'amount_type'    => ['required'],
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'package_id' => ['required', 'numeric', 'exists:package,id'],
            'active_before'    => ['required'],
            'status'    => ['required'],
        ]);

        $payment->fill($request->only(['amount', 'amount_type', 'user_id', 'package_id', 'active_before', 'status']));

        $payment->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.payments.edit', ['payment' => $payment->id]);
    }

    /**
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function remove(Payment $payment): RedirectResponse
    {
        $payment->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.payments.index');
    }
}
