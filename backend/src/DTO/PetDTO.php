<?php

namespace App\DTO;

use Doctrine\Common\Collections\Expr\Value;

readonly class PetDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $status,
        public NamedElementDTO $category,
        public ?array $tags,
        public ?array $photoUrls
    ) {}

    public static function fromArray(array $data): self
    {
        return new PetDTO(
            id: $data['id'] ?? 0,
            name: $data['name'] ?? '',
            status: $data['status'] ?? 'available',
            category: NamedElementDTO::fromArray($data['category'] ?? []),
            tags: array_map(fn($tag) => NamedElementDTO::fromArray($tag), $data['tags'] ?? []),
            photoUrls: $data['photoUrls'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'category' => $this->category?->toArray(),
            'tags' => array_map(fn($tag) => $tag->toArray(), $this->tags ?? []),
            'photoUrls' => $this->photoUrls
        ];
    }
}
