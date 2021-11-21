<?php

namespace Modules\User\Events\Auth;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\User;

class UserRegisteredEvent
{
    use SerializesModels, Dispatchable;

    /**
     * User instance.
     *
     * @var User $user
     */
    public User $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

//    /**
//     * Get the channels the event should be broadcast on.
//     *
//     * @return array
//     */
//    public function broadcastOn()
//    {
//        return [];
//    }
}
