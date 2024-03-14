<?php

namespace App\Http\Requests\Price;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Price Update RequestValidation
 * 
 * @AO\Schema(
 *      schema="PriceeUpdateRequest",
 * 
 *      @AO\ Property(property="car_id", type="string", example="", description="id машины"),
 *      @AO\ Property(property="minute", type="integer", example="", description="стоимость в минуту"),
 *      @AO\ Property(property="day", type="integer", example="", description="Стоимость в день"),
 * )
 */
class UpdatePriceRequest extends FormRequest
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
            'minute' => 'filled|integer',
            'day' => 'filled|integer',
        ];
    }
}
