<?php

namespace Tests\Unit\Src\Client\Presentation\Transformers;

use App\Src\Client\Domain\Entities\Client;
use App\Src\Client\Presentation\Transformers\ClientTransformer;
use Tests\TestCase;

class ClientTransformerTest extends TestCase
{
    public function test_it_transforms_a_client_entity_to_array(): void
    {
        $client = new Client(
            id: 1,
            name: 'Empresa Alpha',
            slug: 'empresa-alpha',
            description: 'Cliente premium',
            isActive: true,
            createdAt: '2026-04-09 10:00:00',
            updatedAt: '2026-04-09 11:00:00',
        );

        $result = ClientTransformer::transform($client);

        $this->assertSame([
            'id' => 1,
            'name' => 'Empresa Alpha',
            'slug' => 'empresa-alpha',
            'description' => 'Cliente premium',
            'is_active' => true,
            'created_at' => '2026-04-09 10:00:00',
            'updated_at' => '2026-04-09 11:00:00',
        ], $result);
    }
}