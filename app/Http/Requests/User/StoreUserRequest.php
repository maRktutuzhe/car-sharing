<?php

namespace App\Http\Requests\User;

use App\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * User Stroe Request Validation
 *
 * @OA\Schema(
 *      schema="UserStoreRequest",
 *
 *      @OA\Property(property="last_name", type="string", example="", description="Фамилия"),
 *      @OA\Property(property="first_name", type="string", example="", description="Имя"),
 *      @OA\Property(property="middle_name", type="string", example="", description="Отчество"),
 *      @OA\Property(property="email", type="string", example="", description="Email"),
 *      @OA\Property(property="phone_number", type="char", example="", description="Номер телефона"),
 *      @OA\Property(property="password", type="string", example="", description="Пароль"),
 *      @OA\Property(property="city", type="string", example="", description="Город"),
 *      @OA\Property(property="passport", type="string", example="", description="Паспорт"),
 *      @OA\Property(property="licence", type="string", example="", description="Водительские права"),
 * )
 */
class StoreUserRequest extends FormRequest
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
        $this->merge([
            'balance' => $this->input('balance', 0),
        ]);
        return [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'numeric|nullable|digits:11',
            'password' => 'required|string|max:255',
            'city' => 'nullable|string',
            'passport' => 'nullable|string',
            'licence' => 'nullable|string',
            'status' => ['required', 'string', Rule::in(UserStatus::Values())],
            'balance' => 'required|integer',
        ];
    }
}
