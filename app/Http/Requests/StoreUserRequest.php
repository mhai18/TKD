<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\UserType;

class StoreUserRequest extends FormRequest
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
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
