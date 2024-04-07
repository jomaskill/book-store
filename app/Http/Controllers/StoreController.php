<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return StoreResource::collection(Store::all());
    }

    public function store(StoreRequest $request): StoreResource
    {
        return new StoreResource(
            Store::create($request->validated())->refresh()
        );
    }

    public function show(Store $store): StoreResource
    {
        return new StoreResource($store);
    }

    public function update(StoreRequest $request, Store $store): StoreResource
    {
        $store->update($request->validated());

        return new StoreResource($store);
    }

    public function destroy(Store $store): Response
    {
        $store->delete();

        return response()->noContent();
    }
}
