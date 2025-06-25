<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\CivilStatus;
use App\Enums\BeltLevel;
use App\Enums\Religion;
use App\Enums\UserType;

class StorePlayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'extension_name' => 'nullable|string|max:10',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required|string|unique:users,contact_number',
            'user_type' => ['required', new Enum(UserType::class)],

            // Check uniqueness across BOTH players and committees
            'member_id' => [
                'required',
                'string',
                'unique:players,member_id',
                'unique:committees,member_id',
            ],
            'pta_id' => [
                'nullable',
                'string',
                'unique:players,pta_id',
                'unique:committees,pta_id',
            ],
            'ncc_id' => [
                'nullable',
                'string',
                'unique:players,ncc_id',
                'unique:committees,ncc_id',
            ],

            'chapter_id' => 'required|integer|exists:chapters,id',
            'coach_id' => 'required|integer|exists:users,id',

            'birth_date' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'civil_status' => ['required', new Enum(CivilStatus::class)],
            'belt_level' => ['required', new Enum(BeltLevel::class)],
            'religion' => ['required', new Enum(Religion::class)],
            'province_code' => 'required|exists:provinces,province_code',
            'municipality_code' => 'required|exists:municipalities,municipality_code',
            'brgy_code' => 'required|exists:brgys,brgy_code',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}
