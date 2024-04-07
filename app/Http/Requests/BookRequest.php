<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'     => ['required'],
            'isbn'     => ['required', 'integer'],
            'value'    => ['required', 'numeric']
        ];
    }
}
