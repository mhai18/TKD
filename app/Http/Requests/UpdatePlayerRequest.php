<?php

namespace App\Http\Requests;

use App\Enums\BeltLevel;
use App\Enums\CivilStatus;
use App\Enums\Religion;
use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdatePlayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $player = $this->route('player');

        return [
            'first_name'     => 'required|string|max:50',
            'middle_name'    => 'nullable|string|max:50',
            'last_name'      => 'required|string|max:50',
            'extension_name' => 'nullable|string|max:10',
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($player->user_id)],
            'contact_number' => ['required', 'string', 'max:20', Rule::unique('users', 'contact_number')->ignore($player->user_id)],
            'user_type' => ['required', new Enum(UserType::class)],

            'member_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('players', 'member_id')->ignore($player->id),
                Rule::unique('committees', 'member_id')->ignore($player->id),
            ],
            'pta_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('players', 'pta_id')->ignore($player->id),
                Rule::unique('committees', 'pta_id')->ignore($player->id),
            ],
            'ncc_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('players', 'ncc_id')->ignore($player->id),
                Rule::unique('committees', 'ncc_id')->ignore($player->id),
            ],

            'birth_date'        => 'required|date',
            'gender'            => 'required|in:Male,Female',
            'civil_status'      => ['required', new Enum(CivilStatus::class)],
            'belt_level'        => ['required', new Enum(BeltLevel::class)],
            'religion'          => ['required', new Enum(Religion::class)],
            'province_code'     => 'required|numeric|exists:provinces,province_code',
            'municipality_code' => 'required|numeric|exists:municipalities,municipality_code',
            'brgy_code'         => 'required|numeric|exists:brgys,brgy_code',
            'avatar'            => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}
