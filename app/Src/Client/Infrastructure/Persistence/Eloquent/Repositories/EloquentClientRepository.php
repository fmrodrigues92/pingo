<?php

namespace App\Src\Client\Infrastructure\Persistence\Eloquent\Repositories;

use App\Src\Client\Domain\Entities\Client;
use App\Src\Client\Domain\Repositories\ClientRepositoryInterface;
use App\Src\Client\Infrastructure\Persistence\Eloquent\Models\ClientModel;

/**
 * Eloquent implementation of the ClientRepositoryInterface.
 *
 * Handles persistence operations for Client entities using the Eloquent ORM.
 */
class EloquentClientRepository implements ClientRepositoryInterface
{

    /**
     * Persist a new Client entity to the database.
     *
     * @param  Client  $client  The client entity to create.
     * @return Client           The created client entity mapped from the persisted model.
     */
    public function create(Client $client): Client
    {
        $model = ClientModel::query()->create([
            'name' => $client->getName(),
            'slug' => $client->getSlug(),
            'description' => $client->getDescription(),
            'is_active' => $client->isActive(),
        ]);

        return $this->mapToEntity($model);
    }

    /**
     * Find a Client entity by its slug.
     *
     * @param  string  $slug  The unique slug to search for.
     * @return Client|null    The matching client entity, or null if not found.
     */
    public function findBySlug(string $slug): ?Client
    {
        $model = ClientModel::query()
            ->where('slug', $slug)
            ->first();

        return $model ? $this->mapToEntity($model) : null;
    }

    /**
     * Retrieve a list of Client entities, optionally filtered by a search term.
     *
     * Results are ordered alphabetically by name. When a search term is provided,
     * it is matched against both the name and slug fields.
     *
     * @param  string|null  $search  Optional search term to filter by name or slug.
     * @return Client[]              Array of matching client entities.
     */
    public function list(?string $search = null): array
    {
        $query = ClientModel::query()->orderBy('name');

        if ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        return $query->get()
            ->map(fn (ClientModel $model) => $this->mapToEntity($model))
            ->all();
    }

    /**
     * Map an Eloquent ClientModel to a Client domain entity.
     *
     * @param  ClientModel  $model  The Eloquent model to map.
     * @return Client               The resulting domain entity.
     */
    private function mapToEntity(ClientModel $model): Client
    {
        return new Client(
            id: $model->id,
            name: $model->name,
            slug: $model->slug,
            description: $model->description,
            isActive: $model->is_active,
            createdAt: $model->created_at?->toDateTimeString(),
            updatedAt: $model->updated_at?->toDateTimeString(),
        );
    }
}