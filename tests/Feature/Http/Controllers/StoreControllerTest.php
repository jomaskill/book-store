<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    public function test_it_should_index_stores(): void
    {
        $stores = Store::factory(10)->create();

        $this->getJson('api/store')
            ->assertSuccessful()
            ->assertJsonPath('data', $stores->map(fn(Store $store) => [
                'id'         => $store->id,
                'name'       => $store->name,
                'address'    => $store->address,
                'active'     => $store->active,
                'created_at' => $store->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $store->updated_at->format('Y-m-d H:i:s')
            ])->toArray());
    }

    public function test_it_should_create_a_store(): void
    {
        $response = $this->postJson('api/store', [
            'name'    => 'random name',
            'address' => 'random address'
        ])
            ->assertCreated()
            ->assertJsonFragment(json_decode((New StoreResource(Store::first()))->toJson(), true));

        $this->assertDatabaseHas(Store::class, json_decode($response->baseResponse->content(), true)['data']);
    }

    public function test_it_should_show_a_store(): void
    {
        $store = Store::factory()->create();

        $this->getJson("api/store/$store->id")
            ->assertSuccessful()
            ->assertJsonFragment(json_decode((New StoreResource($store))->toJson(), true));
    }

    public function test_it_should_update_a_store(): void
    {
        $store = Store::factory()->create();

        $updateData = [
            'name'    => 'a new name',
            'address' => 'a new address'
        ];

        $this->putJson("api/store/$store->id", $updateData)
            ->assertSuccessful()
            ->assertJsonFragment(json_decode((New StoreResource($store->refresh()))->toJson(), true));

        $this->assertDatabaseHas(Store::class, [
            ...$store->toArray(),
            ...$updateData
        ]);

    }

    public function test_it_should_delete_a_store(): void
    {
        $stores = Store::factory(2)->create();
        $deletedStore = $stores->first();

        $this->deleteJson("api/store/$deletedStore->id")
            ->assertNoContent();

        $this->assertSoftDeleted(Store::class, $deletedStore->toArray());
        $this->assertNotSoftDeleted(Store::class, $stores->last()->toArray());
    }
}
