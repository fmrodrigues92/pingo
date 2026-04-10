<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\User;
use App\Src\Client\Infrastructure\Persistence\Eloquent\Models\ClientModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_client(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/clients', [
            'name' => 'Empresa Alpha',
            'description' => 'Cliente da área financeira',
            'is_active' => true,
        ]);

        $response->assertCreated()
            ->assertJson([
                'success' => true,
                'message' => 'Client created successfully.',
                'data' => [
                    'name' => 'Empresa Alpha',
                    'slug' => 'empresa-alpha',
                    'description' => 'Cliente da área financeira',
                    'is_active' => true,
                ],
            ]);

        $this->assertDatabaseHas('clients', [
            'name' => 'Empresa Alpha',
            'slug' => 'empresa-alpha',
            'is_active' => true,
        ]);
    }

    public function test_authenticated_user_can_list_clients(): void
    {
        $user = User::factory()->create();

        ClientModel::query()->create([
            'name' => 'Empresa Alpha',
            'slug' => 'empresa-alpha',
            'description' => null,
            'is_active' => true,
        ]);

        ClientModel::query()->create([
            'name' => 'Empresa Beta',
            'slug' => 'empresa-beta',
            'description' => null,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/clients?search=alpha');

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Empresa Alpha')
            ->assertJsonPath('data.0.slug', 'empresa-alpha');
    }
}