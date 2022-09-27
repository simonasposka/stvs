<?php

namespace App\Http\Requests\TeamsController;

use App\DTOs\TeamsController\StoreRequestDTO;
use App\Rules\IsUserIdValid;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'min:0', new isUserIdValid()],
            'title'   => ['required', 'string', 'min: 1', 'max:255'],
            'description' => ['sometimes', 'string', 'nullable', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'user_id is required',
            'title.required'   => 'title is required',
        ];
    }

    public function getDTO(): StoreRequestDTO
    {
        $validated = $this->validated();

        return new StoreRequestDTO(
            $validated['user_id'],
            $validated['title'],
            $validated['description'] ?? '',
        );
    }
}
