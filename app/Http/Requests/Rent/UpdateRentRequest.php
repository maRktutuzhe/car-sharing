<?php

namespace App\Http\Requests\Rent;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Rent Update RequestValidation
 * 
 * @AO\Schema(
 *      schema="RentUpdateRequest",
 * 
 *      @AO\ Property(property="user_id", type="string", example="", description="id модели"),
 *      @AO\ Property(property="car_id", type="string", example="", description="название марки"),
 *      @AO\ Property(property="event", type="string", example="", description="номер"),
 *      @AO\ Property(property="petrol", type="float", example="", description="цвет"),
 *      @AO\ Property(property="location_id", type="string", example="", description="статус"),
 *      @AO\ Property(property="kilometer", type="float", example="", description="повреждения"),
 * )
 */
class UpdateRentRequest extends FormRequest
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
            'user_id' => 'filled|uuid|exists:users,id',
            'car_id' => 'filled|uuid|exists:cars,id',
            'event' => 'filled|string|max:255',
            'petrol' => 'filled|numeric',
            'location_id' => 'filled|uuid|exists:locations,id',
            'kilometer' => 'filled|numeric',
        ];
    }
}
