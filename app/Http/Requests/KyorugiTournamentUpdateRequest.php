<?php

namespace App\Http\Requests;

use App\Enums\TournamentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class KyorugiTournamentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_category_id'   => 'sometimes|required|exists:event_categories,id',
            'name'                => 'sometimes|required|string|max:255',
            'start_date'          => 'sometimes|required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'registration_start'  => 'sometimes|required|date',
            'registration_end'    => 'sometimes|required|date|after_or_equal:registration_start',
            'venue_name'          => 'required|string|max:255',
            'province_code'       => 'sometimes|required|exists:provinces,province_code',
            'municipality_code'   => 'sometimes|required|exists:municipalities,municipality_code',
            'brgy_code'           => 'sometimes|required|exists:brgys,brgy_code',
            'status'              => ['nullable', new Enum(TournamentStatus::class)],
            'remarks'             => 'nullable|string',
            'banner'              => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}
