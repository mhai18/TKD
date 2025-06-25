<?php

namespace App\Http\Requests;

use App\Enums\BeltLevel;
use App\Enums\CivilStatus;
use App\Enums\Religion;
use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateCommitteeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow access unless you’re handling this via policies
    }

    public function rules(): array
    {
        $committee = $this->route('committee'); // assuming route-model binding
        if (!$committee) {
            throw new \InvalidArgumentException('Committee not found in the route.');
        }

        return [
            'first_name'     => 'required|string|max:50',
            'middle_name'    => 'nullable|string|max:50',
            'last_name'      => 'required|string|max:50',
            'extension_name' => 'nullable|string|max:10',
            'email'          => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($committee->user_id)],
            'contact_number' => ['required', 'string', 'max:20', Rule::unique('users', 'contact_number')->ignore($committee->user_id)],
            'user_type' => ['required', new Enum(UserType::class)],

            'member_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('players', 'member_id')->ignore($committee->id),
                Rule::unique('committees', 'member_id')->ignore($committee->id),
            ],
            'pta_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('players', 'pta_id')->ignore($committee->id),
                Rule::unique('committees', 'pta_id')->ignore($committee->id),
            ],
            'ncc_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('players', 'ncc_id')->ignore($committee->id),
                Rule::unique('committees', 'ncc_id')->ignore($committee->id),
            ],

            'birth_date'        => 'required|date',
            'gender'            => 'required|in:Male,Female',
            'civil_status'      => ['required', new Enum(CivilStatus::class)],
            'belt_level'        => ['required', new Enum(BeltLevel::class)],
            'religion'          => ['required', new Enum(Religion::class)],
            'province_code'     => 'required|numeric|exists:provinces,province_code',
            'municipality_code' => 'required|numeric|exists:municipalities,municipality_code',
            'brgy_code'         => 'required|numeric|exists:brgys,brgy_code',
        ];
    }
}
