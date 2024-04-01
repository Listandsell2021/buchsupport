<?php

namespace App\Libraries\Services;

use App\Helpers\Config\ImageConfig;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductImageManager
{


    /**
     * Store Product Image
     *
     * @param $productId
     * @param UploadedFile $image
     * @param string $imageName
     * @return string
     */
    public static function store($productId, UploadedFile $image, string $imageName): string
    {
        $imagePath = Storage::disk(ImageConfig::getDisk())->putFileAs($productId, $image, $imageName);
        self::generateThumbnails(ImageConfig::getAbsoluteStorageFolder($imagePath));

        return $imagePath ?? '';
    }

    /**
     * Generate Image Thumbnail
     *
     * @param string $imagePath
     * @return bool
     */
    public static function generateThumbnails(string $imagePath): bool
    {
        if (!File::exists($imagePath)) {
            return false;
        }

        $folderPath = dirname($imagePath);
        $thumbExtension = ImageConfig::getThumbExtension();
        $filename = pathinfo($imagePath, PATHINFO_FILENAME);

        foreach (ImageConfig::getThumbSizes() as $thumbSize) {
            $thumbImage = Image::make($imagePath);
            $thumbImage->resize($thumbSize['width'], $thumbSize['height'], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($folderPath.'/'.$filename.$thumbSize['prefix'].'.'.$thumbExtension);
        }
        return true;
    }


    /**
     * Delete Image Thumbnail
     *
     * @param string $imagePath
     * @return bool
     */
    public static function deleteThumbnails(string $imagePath): bool
    {
        if (!File::exists($imagePath)) {
            return false;
        }

        $folderPath = dirname($imagePath);
        $extension = ImageConfig::getThumbExtension();
        $filename = pathinfo($imagePath, PATHINFO_FILENAME);

        foreach (ImageConfig::getThumbSizes() as $thumbSize) {
            $thumbPath = $folderPath.'/'.$filename.$thumbSize['prefix'].'.'.$extension;
            if (File::exists($thumbPath)) {
                File::delete($thumbPath);
            }
        }

        return true;
    }



    /**
     * Get Product Image Url
     *
     * @param string $imageRelativePath
     * @return string
     */
    public static function getImageUrl(string $imageRelativePath): string
    {
        return Storage::disk(ImageConfig::getDisk())->url($imageRelativePath);
    }

    /**
     * Get web Url of Product Image
     *
     * @param $productId
     * @param string $imageRelativePath
     * @return string
     */
    public static function getWebUrl(string $imageRelativePath): string
    {
        $imagePath = ImageConfig::getAbsoluteStorageFolder($imageRelativePath);

        if (!File::exists($imagePath)) {
            return '';
        }

        $extension = ImageConfig::getThumbExtension();
        $filename = pathinfo($imagePath, PATHINFO_FILENAME);
        $basename = basename($imagePath);

        $webFileName = $filename.ImageConfig::getWebSize().'.'.$extension;

        return Storage::disk(ImageConfig::getDisk())->url(str_replace($basename, $webFileName, $imageRelativePath));
    }


    /**
     * Get thumb Url of Product Image
     *
     * @param $productId
     * @param string $imageRelativePath
     * @return string
     */
    public static function getThumbUrl(string $imageRelativePath): string
    {
        $imagePath = ImageConfig::getAbsoluteStorageFolder($imageRelativePath);

        if (!File::exists($imagePath)) {
            return '';
        }

        $extension = ImageConfig::getThumbExtension();
        $filename = pathinfo($imagePath, PATHINFO_FILENAME);
        $basename = basename($imagePath);

        $thumbFileName = $filename.ImageConfig::getThumbSize().'.'.$extension;

        return Storage::disk(ImageConfig::getDisk())->url(str_replace($basename, $thumbFileName, $imageRelativePath));
    }


    /**
     * Delete Image and thumbnails
     *
     * @param $imagePath
     * @return true
     */
    public static function deleteImageAndThumbnails($imagePath): bool
    {
        self::deleteThumbnails(ImageConfig::getAbsoluteStorageFolder($imagePath));

        Storage::disk(ImageConfig::getDisk())->delete($imagePath);

        return true;
    }


    /**
     * Delete Product Image Folder
     *
     * @param $productId
     * @return bool
     */
    public static function deleteFolder($productId): bool
    {
        return Storage::disk(ImageConfig::getDisk())->deleteDirectory($productId);
    }

}