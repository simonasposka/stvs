<?php

namespace App\Http\Requests\ArticlesController;

use App\DTOs\ArticlesController\StoreRequestDTO;
use App\Rules\IsTeamIdValid;
use App\Rules\IsUserIdValid;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'team_id' => ['required', 'integer', 'min:0', new isTeamIdValid(), /* TODO: new isUserInTeam() */],
            'title'   => ['required', 'string', 'min: 1', 'max:255'],
            'text' => ['required', 'string', 'min: 1', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'team_id.required' => 'team_id is required',
            'title.required'   => 'title is required',
            'text.required'   => 'title is required',
        ];
    }

    public function getDTO(): StoreRequestDTO
    {
        $validated = $this->validated();

        return new StoreRequestDTO(
            $validated['team_id'],
            $validated['title'],
            $validated['text'],
        );
    }
}
