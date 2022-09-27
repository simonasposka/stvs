<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class IsEmailValid implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return is_null(User::findByEmail(strtolower($value)));
    }

    public function message(): string
    {
        return 'Email already exists';
    }
}
