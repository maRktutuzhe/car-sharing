<?php

namespace App\Http\Requests\State;

use Illuminate\Foundation\Http\FormRequest;

/**
 * State Update RequestValidation
 * 
 * @AO\Schema(
 *      schema="UpdateStateRequest",
 * 
 *      @AO\ Property(property="car_id", type="string", example="", description="id машины"),
 *      @AO\ Property(property="doors", type="boolean", example="", description="закрыты двери"),
 *      @AO\ Property(property="engine", type="boolean", example="", description="выключен двигатель"),
 *      @AO\ Property(property="block", type="boolean", example="", description="машина заблокирована"),
 * )
 */
class UpdateStateRequest extends FormRequest
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
            'doors' => 'filled|boolean',
            'engine' => 'filled|boolean',
            'block' => 'filled|boolean',
        ];
    }
}
