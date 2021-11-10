<?php

namespace Modules\User\Rules\Auth;

use Illuminate\Contracts\Validation\Rule;
use Modules\User\Entities\User;

class LoginRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return User::wherePhone($value)->orWhere('email', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('auth.failed');
    }
}
