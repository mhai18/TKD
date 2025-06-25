<?php

namespace App\Http\Requests;

use App\Enums\Division;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class KyorugiTournamentPlayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'player_id' => 'required|exists:users,id',
            'tournament_id' => 'required|exists:kyorugi_tournaments,id',
            'division'  => ['required', new Enum(Division::class)],
            'weight'    => 'required|numeric'
        ];
    }
}
