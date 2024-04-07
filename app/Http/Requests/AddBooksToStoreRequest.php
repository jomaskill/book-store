<?php

namespace App\Http\Requests;

use App\Models\Book;
use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddBooksToStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'store_id' => ['required', Rule::exists(Store::class, 'id')],
            'book_id'  => ['required', Rule::exists(Book::class, 'id')],
            'quantity' => ['required', 'integer', 'gt:0'],
        ];
    }
}
