<?php

namespace App\Services\Admin;

use App\Models\ProductCategory;

class ProductCategoryService
{

    /**
     * Search And Paginate
     *
     * @param array $data
     * @return mixed
     */
    public function searchAndPaginate(array $data): mixed
    {
        $filters = $data['filters'] ?? [];

        return ProductCategory::where(function($query) use ($filters) {
                if (hasInput($filters['name'] ?? '')) {
                    $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
                }
                if (hasInput($filters['is_active'] ?? '')) {
                    $query->where('is_active', (int) $filters['is_active']);
                }
            })
            ->sorting(['name', 'is_active'], 'admins.id')
            ->paginate(getPerPageTotal());
    }

    /**
     * Get specific record by id.
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getById(int $categoryId): mixed
    {
        return ProductCategory::find($categoryId);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        return ProductCategory::create($data);
    }

    /**
     * Update specific record to database.
     *
     * @param int $categoryId
     * @param array $data
     * @return void
     */
    public function update(int $categoryId, array $data)
    {
        ProductCategory::where('id', $categoryId)->update($data);
    }

    /**
     * Delete specific record.
     *
     * @param int $categoryId
     * @return void
     */
    public function delete(int $categoryId)
    {
        ProductCategory::where('id', $categoryId)->delete();
    }


    /**
     * Delete specific record.
     *
     * @param array $categoryIds
     * @return void
     */
    public function deleteBulk(array $categoryIds)
    {
        ProductCategory::whereIn('id', $categoryIds)->delete();
    }


    /**
     * Update Active Status
     *
     * @param int $categoryId
     * @param int $isActive
     * @return void
     */
    public function updateActiveStatus(int $categoryId, int $isActive): void
    {
        ProductCategory::where('id', $categoryId)->update(['is_active' => $isActive]);
    }


    /**
     * Update Bulk Active Status
     *
     * @param array $categoryIds
     * @param int $isActive
     * @return void
     */
    public function updateBulkActiveStatus(array $categoryIds, int $isActive): void
    {
        ProductCategory::whereIn('id', $categoryIds)->update(['is_active' => $isActive]);
    }


    /**
     * Get Active Categories
     *
     * @return mixed
     */
    public function getActiveCategories(): mixed
    {
        return ProductCategory::where('is_active', 1)->orderBy('name')->get();
    }



}
