<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'    => ['required', 'string'],
            'address' => ['required'],
            'active'  => ['sometimes', 'bool'],
        ];
    }
}
