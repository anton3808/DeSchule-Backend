<?php

namespace Modules\User\Rules\Auth;

use Illuminate\Contracts\Validation\Rule;
use Modules\User\Entities\User;

class PasswordChangeRule implements Rule
{
    private User $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = request()->user('sanctum');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return password_verify($value, optional($this->user)->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('auth.password');
    }
}
