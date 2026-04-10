<?php

namespace Tests\Unit\Src\Client\Application\UseCases;

use App\Src\Client\Application\UseCases\ListClientsUseCase;
use App\Src\Client\Domain\Entities\Client;
use App\Src\Client\Domain\Repositories\ClientRepositoryInterface;
use Mockery;
use Tests\TestCase;

class ListClientsUseCaseTest extends TestCase
{
    public function test_it_returns_clients_from_repository(): void
    {
        $repository = Mockery::mock(ClientRepositoryInterface::class);

        $clients = [
            new Client(1, 'Empresa Alpha', 'empresa-alpha', null, true),
            new Client(2, 'Empresa Beta', 'empresa-beta', null, true),
        ];

        $repository->shouldReceive('list')
            ->once()
            ->with('empresa')
            ->andReturn($clients);

        $useCase = new ListClientsUseCase($repository);

        $result = $useCase->execute('empresa');

        $this->assertCount(2, $result);
        $this->assertSame('Empresa Alpha', $result[0]->getName());
        $this->assertSame('Empresa Beta', $result[1]->getName());
    }
}