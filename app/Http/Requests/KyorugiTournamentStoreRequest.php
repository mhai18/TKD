<?php

namespace App\Http\Requests;

use App\Enums\TournamentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class KyorugiTournamentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Or add your auth logic
    }

    public function rules(): array
    {
        return [
            'event_category_id'   => 'required|exists:event_categories,id',
            'name'                => 'required|string|max:255',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'registration_start'  => 'required|date|before:end_date|before_or_equal:start_date',
            'registration_end'    => 'required|date|after_or_equal:registration_start|before_or_equal:start_date',
            'venue_name'          => 'required|string|max:255',
            'province_code'       => 'required|exists:provinces,province_code',
            'municipality_code'   => 'required|exists:municipalities,municipality_code',
            'brgy_code'           => 'required|exists:brgys,brgy_code',
            'created_by'          => 'required|exists:users,id',
            'status'              => ['nullable', new Enum(TournamentStatus::class)],
            'remarks'             => 'nullable|string',
            'banner'              => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}
