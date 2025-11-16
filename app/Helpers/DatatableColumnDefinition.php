<?php

namespace App\Helpers;

class DatatableColumnDefinition
{
    public function __construct(
        public ?string $data = null,
        public ?string $name = null,
        public bool $searchable = false,
        public bool $orderable = false,
        public ?string $searchValue = null,
        public bool $searchRegex = false
    ) {}

    // Optional: Array constructor for easy creation from request data
    public static function fromArray(array $data): self
    {
        return new self(
            data: $data['data'] ?? null,
            name: $data['name'] ?? null,
            searchable: $data['searchable'] ?? false,
            orderable: $data['orderable'] ?? false,
            searchValue: $data['searchValue'] ?? null,
            searchRegex: $data['searchRegex'] ?? false
        );
    }

    // Optional: Convert to array
    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'name' => $this->name,
            'searchable' => $this->searchable,
            'orderable' => $this->orderable,
            'searchValue' => $this->searchValue,
            'searchRegex' => $this->searchRegex,
        ];
    }
}
