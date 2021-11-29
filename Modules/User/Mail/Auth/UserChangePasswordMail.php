<?php

namespace Modules\User\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Entities\User;

class UserChangePasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private User $user;
    private string $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, string $code)
    {
        $this->user = $user;
        $this->code = $code;

        $this->subject = __('mail.user.change-password.subject');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): UserChangePasswordMail
    {
        return $this->view('email.user.change-password')->with([
            'user' => $this->user,
            'code' => $this->code
        ]);
    }
}
