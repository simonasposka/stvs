<?php

namespace App\Http\Requests\TeamUsersController;

use App\DTOs\TeamUsersController\UpdateRequestDTO;
use App\Rules\IsUserIdValid;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'min:0', new isUserIdValid()],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'user_id is required',
        ];
    }

    public function getDTO(): UpdateRequestDTO
    {
        return new UpdateRequestDTO($this->validated()['user_id']);
    }
}
