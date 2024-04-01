<?php

namespace App\Helpers\Config;

use Illuminate\Support\Facades\Storage;

class ImageConfig
{

    public static function getThumbSizes(): array
    {
        return config('product_image.thumb_sizes');
    }

    public static function getImageExtensions(): array
    {
        return config('product_image.image_extensions');
    }

    public static function getThumbExtension(): string
    {
        return config('product_image.thumb_extension');
    }

    public static function getDisk(): string
    {
        return config('product_image.disk');
    }

    private static function getStorageFolder($folder = ''): string
    {
        return config('product_image.storage_folder').($folder != '' ? DIRECTORY_SEPARATOR.$folder : '');
    }

    public static function getAbsoluteStorageFolder($imagePath = ''): string
    {
        return storage_path('app/public/'.self::getStorageFolder($imagePath));
    }

    public static function getUrl($imagePath): string
    {
        return Storage::disk(self::getDisk())->url($imagePath);
    }

    public static function getThumbSize(): string
    {
        return config('product_image.thumb_size');
    }

    public static function getWebSize(): string
    {
        return config('product_image.web_size');
    }

}