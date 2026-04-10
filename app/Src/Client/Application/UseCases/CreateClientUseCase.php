<?php

namespace App\Src\Client\Application\UseCases;

use App\Src\Client\Application\DTOs\CreateClientInput;
use App\Src\Client\Domain\Entities\Client;
use App\Src\Client\Domain\Repositories\ClientRepositoryInterface;

/**
 * Handle the client creation workflow.
 */
class CreateClientUseCase
{
    /**
     * @param  ClientRepositoryInterface  $clientRepository  Repository used to persist and query clients.
     */
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {}

    /**
     * Create a client from the provided input data.
     *
     * @param  CreateClientInput  $input  Validated input data for client creation.
     * @return Client  The created client entity.
     *
     * @throws \DomainException When the generated or provided slug already exists.
     */
    public function execute(CreateClientInput $input): Client
    {
        $slug = $input->slug ?: $this->generateSlug($input->name);

        $existingClient = $this->clientRepository->findBySlug($slug);

        if ($existingClient) {
            throw new \DomainException('Client slug already exists.');
        }

        $client = new Client(
            id: null,
            name: $input->name,
            slug: $slug,
            description: $input->description,
            isActive: $input->isActive,
        );

        return $this->clientRepository->create($client);
    }

    /**
     * Generate a slug from a human-readable value.
     *
     * @param  string  $value  Source value used to generate the slug.
     * @return string  Normalized slug.
     */
    private function generateSlug(string $value): string
    {
        $slug = preg_replace('/[^A-Za-z0-9]+/', '-', strtolower(trim($value)));

        return trim((string) $slug, '-');
    }
}