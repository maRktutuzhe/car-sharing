<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Car Mark Update RequestValidation
 * 
 * @AO\Schema(
 *      schema="CarMakeUpdateRequest",
 * 
 *      @AO\ Property(property="name", type="string", example="", description="Фамилия"),
 *      @AO\ Property(property="country", type="string", example="", description="Страна-производитель"),
 * )
 */
class UpdateCarMakeRequest extends FormRequest
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
            'name' => 'filled|string|max:255',
            'country' => 'filled|string|max:255',
        ];
    }
}
