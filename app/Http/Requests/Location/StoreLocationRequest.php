<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Location Store RequestValidation
 * 
 * @AO\Schema(
 *      schema="LocationStoreRequest",
 * 
 *      @AO\ Property(property="car_id", type="string", example="", description="id машины"),
 *      @AO\ Property(property="coordinates", type="string", example="", description="координаты"),
 *      )
 */
class StoreLocationRequest extends FormRequest
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
            'car_id' => 'required|uuid|exists:cars,id',
            'coordinates' => 'required',
            'coordinates.latitude' => 'required|numeric|min:51|max:52',
            'coordinates.longitude' => 'required|numeric|min:54|max:56',
        ];
    }
}
