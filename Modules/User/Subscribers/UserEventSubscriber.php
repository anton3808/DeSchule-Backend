<?php

namespace Modules\User\Subscribers;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\User\Events\Auth\UserChangePasswordEvent;
use Modules\User\Events\Auth\UserRegisteredEvent;
use Modules\User\Mail\Auth\UserChangePasswordMail;
use Modules\User\Mail\Auth\UserRegisteredMail;

class UserEventSubscriber
{
    public function handleUserRegisteredEvent(UserRegisteredEvent $event)
    {
        if ($event->user->email) {
            Mail::to($event->user)->send(new UserRegisteredMail($event->user));
        }
    }

    public function handleUserChangePasswordEvent(UserChangePasswordEvent $event)
    {
        if ($event->user->email) {
            $code = strtoupper(Str::random(8));
            if (Cache::put($code, $event->user->id, 60 * 60)) {
                Mail::to($event->user)->send(new UserChangePasswordMail($event->user, $code));
            }
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
            UserRegisteredEvent::class     => 'handleUserRegisteredEvent',
            UserChangePasswordEvent::class => 'handleUserChangePasswordEvent'
        ];
    }
}
