<?php

namespace App\Src\Client\Application\UseCases;

use App\Src\Client\Domain\Repositories\ClientRepositoryInterface;

/**
 * Handle client listing operations.
 */
class ListClientsUseCase
{
    /**
     * @param  ClientRepositoryInterface  $clientRepository  Repository used to retrieve clients.
     */
    public function __construct(
        private ClientRepositoryInterface $clientRepository,
    ) {}

    /**
     * Return the list of clients optionally filtered by a search term.
     *
     * @param  string|null  $search  Optional term used to filter clients.
     * @return array  List of client entities.
     */
    public function execute(?string $search = null): array
    {
        return $this->clientRepository->list($search);
    }
}