<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBooksToStoreRequest;
use App\Models\Store;
use Illuminate\Validation\ValidationException;

class LibraryController extends Controller
{
    public function addBookInStore(AddBooksToStoreRequest $request)
    {
        $store = Store::find($request->get('store_id'));

        $book = $store->books()->find($request->get('book_id'));

        if ($book){
            $book->pivot->increment('quantity', $request->get('quantity'));
        } else{
            $store->books()->attach($request->get('book_id'), ['quantity' => $request->get('quantity')]);
        }

        return response()->noContent();
    }

    public function removeBookInStore(AddBooksToStoreRequest $request)
    {
        $store = Store::find($request->get('store_id'));

        $book = $store->books()->find($request->get('book_id'));

        if (!$book){
            throw ValidationException::withMessages([
                'book_id' => ['Book is not on stock for the Store.']
            ]);
        }

        if ($book->pivot->quantity < $request->get('quantity')){
            throw ValidationException::withMessages([
                'quantity' => ['The quantity can\'t be greater than the quantity on stock.']
            ]);
        }

        $book->pivot->decrement('quantity', $request->get('quantity'));

        return response()->noContent();
    }
}
