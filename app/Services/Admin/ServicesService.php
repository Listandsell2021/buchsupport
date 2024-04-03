<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;


class ServicesService
{

    public function searchAndPaginate($data)
    {
        $filters = $data['filters'] ?? [];

        return Service::where(function($query) use ($filters) {
            if (hasInput($filters['name'] ?? '')) {
                $query->where('services.name', 'LIKE', '%' . $filters['name'] . '%');
            }
        })
            ->sorting(['services.name'], 'services.id')
            ->paginate(getPerPageTotal());
    }


    /**
     * Get specific record by id.
     *
     * @param int $serviceId
     * @return mixed
     */
    public function getById(int $serviceId): mixed
    {
        return Service::find($serviceId);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        return Service::create([
            'name'          => $data['name'],
            'is_active'     => (int) ((bool) ($data['is_active'] ?? 1)),
        ]);
    }

    /**
     * Update specific record to database.
     *
     * @param int $serviceId
     * @param array $data
     * @return void
     */
    public function update(int $serviceId, array $data): void
    {
        Service::where('id', $serviceId)->update(Arr::only($data, Service::fillableProps()));
    }

    /**
     * Delete specific record.
     *
     * @param int $serviceId
     * @return void
     */
    public function delete(int $serviceId): void
    {
        Service::where('id', $serviceId)->delete();
    }


    /**
     * Delete bulk record
     *
     * @param array $serviceIds
     * @return void
     */
    public function deleteBulk(array $serviceIds): void
    {
        Service::whereIn('id', $serviceIds)->delete();
    }


    /**
     * Get All Products
     *
     * @return Collection
     */
    public function getAllServices(): Collection
    {
        return Service::active()->get();
    }

    /**
     * Update Active Status
     *
     * @param int $serviceId
     * @param int $isActive
     * @return bool
     */
    public function updateActiveStatus(int $serviceId, int $isActive): bool
    {
        return (bool) Service::where('id', $serviceId)->update(['is_active' => $isActive]);
    }


}
