<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Car Store RequestValidation
 * 
 * @AO\Schema(
 *      schema="CarStoreRequest",
 * 
 *      @AO\ Property(property="carmake_id", type="string", example="", description="id модели"),
 *      @AO\ Property(property="name", type="string", example="", description="название марки"),
 *      @AO\ Property(property="number", type="string", example="", description="номер"),
 *      @AO\ Property(property="color", type="string", example="", description="цвет"),
 *      @AO\ Property(property="status", type="string", example="", description="статус"),
 *      @AO\ Property(property="damages", type="array", example="", description="повреждения"),
 *      @AO\ Property(property="STS", type="string", example="", description="СТС"),
 *      @AO\ Property(property="PTS", type="string", example="", description="ПТС"),
 * )
 */
class StoreCarRequest extends FormRequest
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
            'carmake_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'status' => 'required|enum:CarStatus::class',
            'damages' => 'nullable',
            'STS' => 'nullable|string|max:255',
            'PTS' => 'nullable|string|max:255',
        ];
    }
}
