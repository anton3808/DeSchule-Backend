<?php

namespace Modules\User\Subscribers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;
use Modules\User\Events\Auth\UserRegisteredEvent;
use Modules\User\Mail\Auth\UserRegisteredMail;

class UserEventSubscriber
{
    public function handleUserRegisteredEvent(UserRegisteredEvent $event)
    {
        if ($event->user->email) {
            Mail::to($event->user)->send(new UserRegisteredMail($event->user));
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     * @return array
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            UserRegisteredEvent::class => 'handleUserRegisteredEvent',
        ];
    }
}
