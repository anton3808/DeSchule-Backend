<?php

namespace Modules\User\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\User;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    private User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        $this->subject = __('mail.user.registered.subject', ['name' => env('APP_NAME')]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): UserRegisteredMail
    {
        return $this->view('email.user.registered')->with([
            'fullName' => $this->user->full_name
        ]);
    }
}
