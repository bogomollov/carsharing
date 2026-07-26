<?php

namespace App\Http\Requests\Bill;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    public function rules(): array
    {
        return [
            'arendators_count' => 'required|integer',
            'balance' => 'required|numeric',
            'type' => 'required|string',
            'status' => 'required|string',
        ];
    }
}
