<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
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
            'coach_id' => 'required|integer|exists:users,id',
            'chapter_name' => 'required|string',
            'date_started' => 'required|date',
            'province_code' => 'required|exists:provinces,province_code',
            'municipality_code' => 'required|exists:municipalities,municipality_code',
            'brgy_code' => 'required|exists:brgys,brgy_code',
        ];
    }
}
