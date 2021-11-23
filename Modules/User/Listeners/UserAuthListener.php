<?php

namespace Modules\User\Listeners;

use Modules\User\Events\Auth\UserRegisteredEvent;

class UserAuthListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

//    /**
//     * Handle the event.
//     *
//     * @param  object  $event
//     * @return void
//     */
//    public function handle($event)
//    {
//        //
//    }

    public function handleRegisteredEvent(UserRegisteredEvent $event)
    {
        dd($event);
    }
}
