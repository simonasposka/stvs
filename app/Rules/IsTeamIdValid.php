<?php

namespace App\Rules;

use App\Models\Team;
use Illuminate\Contracts\Validation\Rule;

class IsTeamIdValid implements Rule
{
    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !is_null(Team::find(intval($value)));
    }

    public function message(): string
    {
        return 'Team does not exist';
    }
}
