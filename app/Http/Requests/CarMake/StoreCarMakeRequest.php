<?php

namespace App\Http\Requests\CarMake;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Car Mark Store RequestValidation
 * 
 * @AO\Schema(
 *      schema="CarMakeStoreRequest",
 * 
 *      @AO\ Property(property="name", type="string", example="", description="Фамилия"),
 *      @AO\ Property(property="country", type="string", example="", description="Страна-производитель"),
 * )
 */
class StoreCarMakeRequest extends FormRequest
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
            'name' => 'require|string|max:255',
            'country' => 'require|string|max:255',
        ];
    }
}
