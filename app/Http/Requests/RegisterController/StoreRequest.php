<?php

namespace App\Http\Requests\RegisterController;

use App\DTOs\RegisterController\StoreRequestDTO;
use App\Rules\IsEmailValid;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'max:255', new IsEmailValid()],
            'password'   => [
                'required',
                'string',
                'min:5',
                'max:255',
//                'regex:/[a-z]/',      // must contain at least one lowercase letter
//                'regex:/[A-Z]/',      // must contain at least one uppercase letter
//                'regex:/[0-9]/',      // must contain at least one digit
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'firstName is required',
            'email.required'    => 'email is required',
            'password.required' => 'password is required',
        ];
    }

    public function getDTO(): StoreRequestDTO
    {
        $validated = $this->validated();

        return new StoreRequestDTO(
            $validated['name'],
            $validated['email'],
            $validated['password'],
        );
    }
}
