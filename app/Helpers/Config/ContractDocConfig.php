<?php

namespace App\Helpers\Config;

use Illuminate\Support\Facades\Storage;

class ContractDocConfig
{

    /**
     * Minimum file size (KB)
     *
     * @return int
     */
    public static function minFileSize(): int
    {
        return config('contract_document.min_size');
    }

    /**
     * Maximum file size (KB)
     *
     * @return int
     */
    public static function maxFileSize(): int
    {
        return config('contract_document.max_size');
    }

    /**
     * Supported File Extensions
     *
     * @return array
     */
    public static function fileExtensions(): array
    {
        return config('contract_document.extensions');
    }

    /**
     * File Storage Disk
     *
     * @return string
     */
    public static function storageDisk(): string
    {
        return config('contract_document.disk');
    }

    /**
     * Get Lead Contract Relative Path
     *
     * @param string $imagePath
     * @return string
     */
    public static function getLeadContractRelativePath(string $imagePath = ''): string
    {
        return config('contract_document.lead_contract_folder').($imagePath != '' ? DIRECTORY_SEPARATOR.$imagePath : '');
    }

    /**
     * Get Lead Contract Absolute Path
     *
     * @param string $imagePath
     * @return string
     */
    public static function getLeadContractAbsolutePath(string $imagePath = ''): string
    {
        return Storage::disk(self::storageDisk())->path(self::getLeadContractRelativePath($imagePath));
    }


    
    /**
     * Get Customer Contract Relative Path
     *
     * @param string $imagePath
     * @return string
     */
    public static function getOrderContractRelativePath(string $imagePath = ''): string
    {
        return config('contract_document.order_contract_folder').($imagePath != '' ? DIRECTORY_SEPARATOR.$imagePath : '');
    }


    /**
     * Get Customer Contract Absolute Path
     *
     * @param string $imagePath
     * @return string
     */
    public static function getOrderContractAbsolutePath(string $imagePath = ''): string
    {
        return Storage::disk(self::storageDisk())->path(self::getLeadContractRelativePath($imagePath));
    }



}