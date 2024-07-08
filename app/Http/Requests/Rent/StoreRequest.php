<?php

namespace App\Http\Requests\Rent;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'id' => 'required|uuid',
            'car_id' => 'required|uuid',
            'arendator_id' => 'required|uuid',
            'status' => 'required|string',
            'start_datetime' => 'required|string',
            'end_datetime' => 'required|string',
            'rented_time' => 'required|integer',
            'total_price' => 'required|numeric',
        ];
    }
}
