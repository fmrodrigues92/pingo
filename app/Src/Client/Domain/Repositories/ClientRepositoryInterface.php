<?php

namespace App\Src\Client\Domain\Repositories;

use App\Src\Client\Domain\Entities\Client;

/**
 * Define persistence operations for client entities.
 */
interface ClientRepositoryInterface
{
    /**
     * Persist a new client entity.
     *
     * @param  Client  $client  Client entity to persist.
     * @return Client  Persisted client entity.
     */
    public function create(Client $client): Client;

    /**
     * Find a client by its slug.
     *
     * @param  string  $slug  Unique client slug.
     * @return Client|null  Matching client entity or null when not found.
     */
    public function findBySlug(string $slug): ?Client;

    /**
     * Return a list of clients optionally filtered by a search term.
     *
     * @param  string|null  $search  Optional filter applied to client data.
     * @return Client[]  Matching client entities.
     */
    public function list(?string $search = null): array;
}