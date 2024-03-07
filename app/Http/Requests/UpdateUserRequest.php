<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'filled|string|max:255',
            'middle_name' => 'filled|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'filled|email|max:255',
            'phone_number' => 'numeric|nullable|digits:11',
            'password' => 'filled|string|max:255',
            'city' => 'nullable|string',
            'passport' => 'nullable|string',
            'licence' => 'nullable|string',
        ];
    }
}
