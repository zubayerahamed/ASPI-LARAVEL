<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DatatableRequestHelper
{
    public function __construct(
        public int $draw,
        public int $start,
        public int $length,
        public string $searchValue,
        public bool $searchRegex,
        public int $orderColumnNo,
        public DatatableSortOrderType $orderType,
        public Collection $columns,
        public string $uniqueId
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            draw: (int) $request->input('draw', 0),
            start: (int) $request->input('start', 0),
            length: (int) $request->input('length', 10),
            searchValue: (string) $request->input('search.value', ''),
            searchRegex: (bool) $request->input('search.regex', false),
            orderColumnNo: (int) $request->input('order.0.column', 0),
            orderType: self::parseOrderType($request->input('order.0.dir', 'asc')),
            columns: self::parseColumns($request),
            uniqueId: (string) $request->input('_', '')
        );
    }

    private static function parseOrderType(?string $orderDir): DatatableSortOrderType
    {
        return match (strtoupper($orderDir ?? 'asc')) {
            'ASC' => DatatableSortOrderType::ASC,
            'DESC' => DatatableSortOrderType::DESC,
            default => DatatableSortOrderType::ASC,
        };
    }

    private static function parseColumns(Request $request): Collection
    {
        $columns = collect();
        $noOfColumns = self::getNumberOfColumns($request);

        for ($i = 0; $i < $noOfColumns; $i++) {
            $columns->push(new DatatableColumnDefinition(
                data: (string) $request->input("columns.{$i}.data", ''),
                name: (string) $request->input("columns.{$i}.name", ''),
                searchable: (bool) $request->input("columns.{$i}.searchable", false),
                orderable: (bool) $request->input("columns.{$i}.orderable", false),
                searchValue: (string) $request->input("columns.{$i}.search.value", ''),
                searchRegex: (bool) $request->input("columns.{$i}.search.regex", false)
            ));
        }

        return $columns;
    }

    private static function getNumberOfColumns(Request $request): int
    {
        $count = 0;
        $parameters = $request->all();

        return count($request->input('columns'));

        // foreach ($parameters as $key => $value) {
        //     if (preg_match('/columns\[\d+\]\[data\]/', $key)) {
        //         $count++;
        //     }
        // }

        // return $count;
    }

    // Helper method to convert to array
    public function toArray(): array
    {
        return [
            'draw' => $this->draw,
            'start' => $this->start,
            'length' => $this->length,
            'searchValue' => $this->searchValue,
            'searchRegex' => $this->searchRegex,
            'orderColumnNo' => $this->orderColumnNo,
            'orderType' => $this->orderType->value,
            'columns' => $this->columns->toArray(),
            'uniqueId' => $this->uniqueId,
        ];
    }
}
