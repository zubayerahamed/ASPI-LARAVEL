<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class DatatableResponseHelper implements Arrayable
{
    public function __construct(
        public int $draw,
        public int $recordsTotal,
        public int $recordsFiltered,
        public Collection|array $data
    ) {}

    // Factory method for easy creation
    public static function create(
        int $draw,
        int $recordsTotal,
        int $recordsFiltered,
        Collection|array $data
    ): self {
        return new self($draw, $recordsTotal, $recordsFiltered, $data);
    }

    // Convert to array for JSON response
    public function toArray(): array
    {
        return [
            'draw' => $this->draw,
            'recordsTotal' => $this->recordsTotal,
            'recordsFiltered' => $this->recordsFiltered,
            'data' => $this->data instanceof Collection ? $this->data->toArray() : $this->data,
        ];
    }

    // Helper method to create response directly
    public function toResponse(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->toArray());
    }
}
