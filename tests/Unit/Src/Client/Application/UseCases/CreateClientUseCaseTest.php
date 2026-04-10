<?php

namespace Tests\Unit\Src\Client\Application\UseCases;

use App\Src\Client\Application\DTOs\CreateClientInput;
use App\Src\Client\Application\UseCases\CreateClientUseCase;
use App\Src\Client\Domain\Entities\Client;
use App\Src\Client\Domain\Repositories\ClientRepositoryInterface;
use DomainException;
use Mockery;
use Tests\TestCase;

class CreateClientUseCaseTest extends TestCase
{
    public function test_it_creates_a_client_successfully(): void
    {
        $repository = Mockery::mock(ClientRepositoryInterface::class);

        $input = new CreateClientInput(
            name: 'Empresa Alpha',
            slug: null,
            description: 'Cliente da área financeira',
            isActive: true,
        );

        $repository->shouldReceive('findBySlug')
            ->once()
            ->with('empresa-alpha')
            ->andReturn(null);

        $repository->shouldReceive('create')
            ->once()
            ->andReturnUsing(function (Client $client) {
                return new Client(
                    id: 1,
                    name: $client->getName(),
                    slug: $client->getSlug(),
                    description: $client->getDescription(),
                    isActive: $client->isActive(),
                    createdAt: now()->toDateTimeString(),
                    updatedAt: now()->toDateTimeString(),
                );
            });

        $useCase = new CreateClientUseCase($repository);

        $client = $useCase->execute($input);

        $this->assertSame(1, $client->getId());
        $this->assertSame('Empresa Alpha', $client->getName());
        $this->assertSame('empresa-alpha', $client->getSlug());
        $this->assertSame('Cliente da área financeira', $client->getDescription());
        $this->assertTrue($client->isActive());
    }

    public function test_it_throws_exception_when_slug_already_exists(): void
    {
        $repository = Mockery::mock(ClientRepositoryInterface::class);

        $existingClient = new Client(
            id: 10,
            name: 'Empresa Alpha',
            slug: 'empresa-alpha',
            description: null,
            isActive: true,
        );

        $repository->shouldReceive('findBySlug')
            ->once()
            ->with('empresa-alpha')
            ->andReturn($existingClient);

        $repository->shouldNotReceive('create');

        $useCase = new CreateClientUseCase($repository);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Client slug already exists.');

        $useCase->execute(new CreateClientInput(
            name: 'Empresa Alpha',
            slug: null,
            description: null,
            isActive: true,
        ));
    }
}