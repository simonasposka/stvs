<?php

namespace App\Http\Requests\UsersController;

use App\DTOs\RegisterController\StoreRequestDTO;
use App\Rules\IsEmailValid;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'   => ['sometimes', 'string', 'max:255'],
            'email'  => ['sometimes', 'string', 'max:255', new IsEmailValid()],
            'password'   => [
                'sometimes',
                'string',
                'min:5',
                'max:255',
            ],
        ];
    }

    public function getDTO(): StoreRequestDTO
    {
        $validated = $this->validated();

        return new StoreRequestDTO(
            $validated['name'] ?? '',
            $validated['email'] ?? '',
            $validated['password'] ?? ''
        );
    }
}
