<?php

namespace App\Http\Requests\Rent;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Rent Store RequestValidation
 * 
 * @AO\Schema(
 *      schema="RentStoreRequest",
 * 
 *      @AO\ Property(property="user_id", type="string", example="", description="id модели"),
 *      @AO\ Property(property="car_id", type="string", example="", description="название марки"),
 *      @AO\ Property(property="event", type="string", example="", description="номер"),
 *      @AO\ Property(property="petrol", type="float", example="", description="цвет"),
 *      @AO\ Property(property="location_id", type="string", example="", description="статус"),
 *      @AO\ Property(property="kilometer", type="float", example="", description="повреждения"),
 * )
 */
class StoreRentRequest extends FormRequest
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
            'user_id' => 'required|uuid|exists:users,id',
            'car_id' => 'required|uuid|exists:cars,id',
            'event' => 'required|string|max:255',
            'petrol' => 'required|numeric',
            'location_id' => 'required|uuid|exists:locations,id',
            'kilometer' => 'required|numeric',
        ];
    }
}
