<?php

namespace App\DTO;

readonly class NamedElementDTO
{
    public function __construct(
        public int $id,
        public string $name
    ){ }

    public static function fromArray(array $data)
    {
        return new NamedElementDTO(id: $data['id'] ?? 0, name: $data['name'] ?? '');
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
