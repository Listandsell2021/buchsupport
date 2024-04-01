<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;


class ProductService
{

    public function searchAndPaginate($data)
    {
        $filters = $data['filters'] ?? [];

        return Product::select('products.*', 'product_categories.name as category_name')
            ->leftJoin('product_categories', 'products.category_id', 'product_categories.id')
            ->where(function($query) use ($filters) {
            if (hasInput($filters['name'] ?? '')) {
                $query->where('products.name', 'LIKE', '%' . $filters['name'] . '%');
            }
            if (hasInput($filters['category_id'] ?? '')) {
                $query->where('products.category_id', (int) $filters['category_id']);
            }
        })
            ->sorting(['products.name', 'product_categories.name'], 'products.id')
            ->paginate(getPerPageTotal());
    }


    /**
     * Get specific record by id.
     *
     * @param int $productId
     * @return mixed
     */
    public function getById(int $productId): mixed
    {
        return Product::find($productId);
    }

    /**
    * Store data to database.
    *
    * @param array $data
    * @return mixed
    */
    public function save(array $data): mixed
    {
        return Product::create([
            'category_id'   => $data['category_id'] ?? null,
            'name'          => $data['name'],
            'description'   => $data['description'] ?? null,
            'youtube_link'  => $data['youtube_link'] ?? null,
            'is_active'     => $data['is_active'] ?? 1,
            'is_archived'   => $data['is_archived'] ?? 0,
        ]);
    }

    /**
     * Update specific record to database.
     *
     * @param int $productId
     * @param array $data
     * @return void
     */
    public function update(int $productId, array $data)
    {
        Product::where('id', $productId)->update(Arr::only($data, Product::fillableProps()));
    }

    /**
     * Delete specific record.
     *
     * @param int $productId
     * @return void
     */
    public function delete(int $productId)
    {
        Product::where('id', $productId)->delete();
    }


    /**
     * Delete bulk record
     *
     * @param array $productIds
     * @return void
     */
    public function deleteBulk(array $productIds): void
    {
        Product::whereIn('id', $productIds)->delete();
    }


    /**
    * Remove media file from storage.
    *
    * @param int $id
    */
    public function removeMedia($id)
    {
        $media = ProductImage::findOrFail($id);
        $media->delete();
        unlink(storage_path('app/public/products/'.$media->name));

        $product = $this->getById($media->product_id);
        $order = 1;
        if($product->media()->count()){
            foreach ($product->media as $media) {
                $media->order_no = $order;
                $media->save();
                $order++;
            }
        }

        return $media;
    }


    /**
     * Get Product with Images
     *
     * @param int $productId
     * @return mixed
     */
    public function getProductWithImages(int $productId): mixed
    {
        return Product::with('images')->where('id', $productId)->first();
    }


    /**
     * Create Product Image
     *
     * @param int $productId
     * @param string $name
     * @param string $imagePath
     * @param int $orderNo
     * @return void
     */
    public function createProductImage(int $productId, string $name, string $imagePath, int $orderNo = 0): void
    {
        if ($orderNo == 0) {
            $orderNo = (int) ProductImage::where('product_id', $productId)->max('order_no');
        }

        ProductImage::create([
            'product_id'    => $productId,
            'name'          => $name,
            'image_path'    => $imagePath,
            'order_no'      => ++$orderNo,
        ]);
    }

    /**
     * Delete Product Image
     *
     * @param int $imageId
     * @return void
     */
    public function deleteProductImage(int $imageId): void
    {
        ProductImage::where('id', $imageId)->delete();
    }

    /**
     * Get Product Images
     *
     * @param $productId
     * @return mixed
     */
    public function getProductImagesByProductId($productId): mixed
    {
        return ProductImage::where('product_id', $productId)->orderBy('order_no')->get();
    }

    /**
     * Get Product Image
     *
     * @param int $imageId
     * @return mixed
     */
    public function getProductImageByImageId(int $imageId): mixed
    {
        return ProductImage::find($imageId);
    }

    /**
     * Sort Product Images
     *
     * @param array $imageIds
     * @return void
     */
    public function sortProductImages(array $imageIds): void
    {
        $inc = 1;
        foreach ($imageIds as $imageId) {
            ProductImage::where('id', $imageId)->update(['order_no' => $inc++]);
        }
    }

    /**
     * Get All Products
     *
     * @return Collection
     */
    public function getAllProducts(): Collection
    {
        return Product::all();
    }


}
