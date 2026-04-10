<?php

namespace App\Src\Client\Presentation\Transformers;

use App\Src\Client\Domain\Entities\Client;

/**
 * Transform client entities into API-friendly arrays.
 */
class ClientTransformer
{
    /**
     * Transform a single client entity into an array.
     *
     * @param  Client  $client  Client entity to transform.
     * @return array<string, mixed>  Transformed client payload.
     */
    public static function transform(Client $client): array
    {
        return [
            'id' => $client->getId(),
            'name' => $client->getName(),
            'slug' => $client->getSlug(),
            'description' => $client->getDescription(),
            'is_active' => $client->isActive(),
            'created_at' => $client->getCreatedAt(),
            'updated_at' => $client->getUpdatedAt(),
        ];
    }

    /**
     * Transform a list of client entities into an array payload.
     *
     * @param  Client[]  $clients  Collection of client entities.
     * @return array<int, array<string, mixed>>  Transformed client payloads.
     */
    public static function transformCollection(array $clients): array
    {
        return array_map(
            fn (Client $client) => self::transform($client),
            $clients
        );
    }
}