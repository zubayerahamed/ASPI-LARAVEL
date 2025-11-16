<?php 

namespace App\Services;

use App\Helpers\DatatableSortOrderType;
use App\Models\Profile;
use Illuminate\Support\Collection;

class ProfileService
{
    /**
     * Get paginated Profiles data
     */
    public function LAD07(
        int $length,
        int $start,
        string $orderColumn,
        DatatableSortOrderType $orderType,
        string $searchValue,
        int $suffix,
        ?string $dependentParam = null
    ): Collection {
        $searchValue = str_replace("'", "''", $searchValue);

        $query = Profile::query();

        // Apply search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                  ->orWhere('description', 'like', "%{$searchValue}%");
                // Add other searchable columns as needed
            });
        }

        // Apply dependent parameter filter if provided
        if (!empty($dependentParam)) {
            $query->where('dependent_column', $dependentParam);
            // Adjust the column name as per your business logic
        }

        // Apply suffix filter
        // $query->where('suffix', $suffix);

        // Apply ordering
        $query->orderBy($orderColumn, $orderType->value);

        // Get paginated results
        return $query->skip($start)
                    ->take($length)
                    ->get();
    }

    /**
     * Get total count for LAD07 with filters
     */
    public function LAD07Count(
        string $orderColumn,
        DatatableSortOrderType $orderType,
        string $searchValue,
        int $suffix,
        ?string $dependentParam = null
    ): int {
        $query = Profile::query();

        // Apply the same filters as in LSA11 method
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                  ->orWhere('description', 'like', "%{$searchValue}%");
            });
        }

        if (!empty($dependentParam)) {
            $query->where('dependent_column', $dependentParam);
        }

        // $query->where('suffix', $suffix);

        return $query->count();
    }
}