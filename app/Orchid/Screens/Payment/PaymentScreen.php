<?php

namespace App\Orchid\Screens\Payment;

use App\Orchid\Layouts\Tables\PaymentListLayout;
use App\Models\Payment;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class PaymentScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'PaymentScreen';

    public function __construct()
    {
        $this->name = __('orchid.pages.payment.index');
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'payments' => Payment::paginate()
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
                ->route('platform.payments.edit')
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
            PaymentListLayout::class
        ];
    }
}
