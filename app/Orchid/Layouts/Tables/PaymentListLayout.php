<?php

namespace App\Orchid\Layouts\Tables;

use App\Models\Payment;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PaymentListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'payments';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('user_id', __('orchid.models.payment.user_id'))
                ->render(function (Payment $payment) {
                    $can = request()->user()->hasAccess('study.levels');
                    return $can
                        ? Link::make($payment->user->name)
                            ->route('platform.payments.edit', ['user' => $payment->user->id])
                        : $payment->user->name;
                }),
            TD::make('package_id', __('orchid.models.payment.package_id'))
                ->render(function (Payment $payment) {
                    $can = request()->user()->hasAccess('study.levels');
                    return $can
                        ? Link::make($payment->package->title)
                            ->route('platform.payments.edit', ['package' => $payment->package->id])
                        : $payment->package->title;
                }),
            TD::make('amount', __('orchid.models.payment.amount'))
                ->render(function (Payment $payment) {
                    return $payment->amount;
                }),
            TD::make('active_before', 'Дійсна до')
                ->render(function (Payment $payment) {
                    return $payment->active_before;
                }),
            TD::make('updated_at', __('orchid.models.default.updated_at'))
                ->render(function (Payment $payment) {
                    return $payment->updated_at->format('d.m.Y H:i:s');
                }),
            TD::make('status', __('orchid.models.payment.status'))
                ->render(function (Payment $payment) {
                    return $payment->status;
                }),
            TD::make()
                ->render(function (Payment $payment) {
                    return Link::make()
                        ->icon('pencil')
                        ->route('platform.payments.edit', ['payment' => $payment->id]);
                })
        ];
    }
}
