<?php

namespace Modules\User\Events\Auth;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\User;

class UserChangePasswordEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
}
