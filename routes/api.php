<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\StoreController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    $token = User::factory()->create()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('store', StoreController::class);
    Route::apiResource('book', BookController::class);
    Route::post('library/add-book-in-store', [LibraryController::class, 'addBookInStore']);
    Route::post('library/remove-book-in-store', [LibraryController::class, 'removeBookInStore']);

    Route::post('/logout', function (Request $request) {
        return $request->user()->currentAccessToken()->delete();
    });
});
