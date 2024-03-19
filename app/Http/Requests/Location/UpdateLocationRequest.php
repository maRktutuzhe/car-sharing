<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Location Update RequestValidation
 * 
 * @AO\Schema(
 *      schema="LocationUpdateRequest",
 * 
 *      @AO\ Property(property="car_id", type="string", example="", description="id машины"),
 *      @AO\ Property(property="coordinates", type="string", example="", description="координаты"),
 *      )
 */
class UpdateLocationRequest extends FormRequest
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
            'car_id' => 'filled|uuid|exists:cars,id',
            'coordinates' => 'filled|string|max:255',
        ];
    }
}
