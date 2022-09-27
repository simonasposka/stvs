<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class IsUserIdValid implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !is_null(User::find(intval($value)));
    }

    public function message(): string
    {
        return 'User does not exist';
    }
}
