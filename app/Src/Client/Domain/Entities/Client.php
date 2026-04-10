<?php

namespace App\Src\Client\Domain\Entities;

/**
 * Domain entity that represents a client.
 */
class Client
{
    /**
     * @param  int|null  $id  Unique client identifier.
     * @param  string  $name  Client name.
     * @param  string  $slug  Unique client slug.
     * @param  string|null  $description  Optional client description.
     * @param  bool  $isActive  Indicates whether the client is active.
     * @param  string|null  $createdAt  Creation timestamp.
     * @param  string|null  $updatedAt  Last update timestamp.
     */
    public function __construct(
        private ?int $id,
        private string $name,
        private string $slug,
        private ?string $description,
        private bool $isActive,
        private ?string $createdAt = null,
        private ?string $updatedAt = null,
    ) {}

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }
}