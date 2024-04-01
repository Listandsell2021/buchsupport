<?php

namespace App\Services\Admin;

use App\Models\SalesPerson;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SalespersonService
{
    /**
    * Get all records.
    *
    * @return SalesPerson
    */
    public function searchAndPaginate(array $data)
    {
        $filters = $data['filters'] ?? [];

        return SalesPerson::where(function($query) use ($filters) {
            if (hasInput($filters['name'] ?? '')) {
                $query->where(
                    DB::raw("CONCAT_WS(' ', salespersons.first_name, salespersons.last_name)"), 'LIKE', '%' . $filters['name'] . '%'
                );
            }
            if (hasInput($filters['email'] ?? '')) {
                $query->where('salespersons.email', 'LIKE', '%'.$filters['email'].'%');
            }
            if (hasInput($filters['gender'] ?? '')) {
                $query->where('salespersons.gender', '=', $filters['gender']);
            }
            if (hasInput($filters['city'] ?? '')) {
                $query->where('salespersons.city', 'LIKE', '%'.$filters['city'].'%');
            }
            if (hasInput($filters['is_active'] ?? '')) {
                $query->where('salespersons.is_active', (int) $filters['is_active']);
            }
        })
        ->sorting([
            'salespersons.first_name', 'salespersons.last_name', 'salespersons.email', 'salespersons.dob',
            'salespersons.gender', 'salespersons.city', 'salespersons.is_active'
        ], 'salespersons.first_name', 'asc')
        ->paginate(getPerPageTotal());
    }


    /**
    * Get specific record by id.
    *
    * @param int $id
    * @return SalesPerson
    */
    public function getById($id)
    {
        return SalesPerson::findOrFail($id);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return SalesPerson
    */
    public function save(array $data)
    {
        return SalesPerson::create(Arr::only($data, SalesPerson::fillableProps()));
    }

    /**
     * Update specific record to database.
     *
     * @param int $userId
     * @param array $data
     * @return void
     */
    public function update(int $userId, array $data): void
    {
        SalesPerson::where('id', $userId)->update(Arr::only($data, SalesPerson::fillableProps()));
    }

    /**
     * Delete specific record.
     *
     * @param int $userId
     * @return void
     */
    public function delete(int $userId): void
    {
        SalesPerson::where('id', $userId)->delete();
    }

    /**
     * @param int $userId
     * @param int $isActive
     * @return void
     */
    public function updateActiveStatus(int $userId, int $isActive)
    {
        SalesPerson::where('id', $userId)->update(['is_active' => $isActive]);
    }


    /**
     * Get Active Salesperson
     *
     * @return mixed
     */
    public function getActiveSalespersons(): mixed
    {
        return SalesPerson::where('is_active', 1)->orderBy('first_name')->get();
    }

}