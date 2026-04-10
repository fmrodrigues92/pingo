<?php

namespace App\Src\Client\Application\DTOs;

/**
 * Data transfer object used to create a client.
 */
class CreateClientInput
{
    /**
     * @param  string  $name  Client display name.
     * @param  string|null  $slug  Optional client slug.
     * @param  string|null  $description  Optional client description.
     * @param  bool  $isActive  Indicates whether the client starts as active.
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $slug,
        public readonly ?string $description,
        public readonly bool $isActive,
    ) {}
}