<?php


namespace App\Libraries\HelperTraits;


use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

trait ImageUpdateHelper
{

    /**
     * Save Image And Get Names
     *
     * @param $directory
     * @param $images
     * @return array
     */
    public function saveImagesAndGetNames($directory, $images): array
    {
        $imageNames = [];
        foreach ($images as $image) {
            $imageNames[] = $this->saveImage($directory, $image);
        }
        return $imageNames;
    }


    /**
     * Save Image to Directory
     *
     * @param $directory
     * @param $image
     * @return string
     */
    public function saveImage($directory, $image): string
    {
        Storage::disk('public')->putFileAs($directory, new File($image), $image->getClientOriginalName());

        return $image->getClientOriginalName();
    }


    /**
     * Get Array for Product Images DB
     *
     * @param $productId
     * @param $images
     * @return array|array[]
     */
    public function getArrayForProductImages($productId, $images)
    {
        $i = 1;
        return array_map(function ($image) use ($productId, &$i) {
            return [
                'product_id' => $productId,
                'image_path' => $productId . DIRECTORY_SEPARATOR . $image,
                'name' => $image,
                'order_no' => $i++,
            ];
        }, $images);
    }

    /**
     * Delete Image
     */
    public function deleteImage($imagePath)
    {
        if (Storage::disk('public')->exists($imagePath))
            return Storage::disk('public')->delete($imagePath);

        return false;
    }


    /**
     * Delete Image
     */
    public function deleteImages($imagePaths)
    {
        foreach ($imagePaths as $imagePath) {
            $this->deleteImage($imagePath);
        }
    }

}
