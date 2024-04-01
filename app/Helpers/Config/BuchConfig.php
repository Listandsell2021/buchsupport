<?php

namespace App\Helpers\Config;

use Illuminate\Support\Facades\Storage;

class BuchConfig
{

    public static function getLeadsImportExtensions(): array
    {
        return config('buch.leads_import_extensions');
    }

    public static function getUserImageExtensions()
    {
        return config('buch.user_image_extensions');
    }

    public static function getUserProfileImageMaxSize()
    {
        return config('buch.user_image_max_size');
    }

    public static function getUserProfileFolder()
    {
        return config('buch.user_image_storage_folder');
    }


    public static function getLeadTableColumns()
    {
        return config('buch.lead_table_columns');
    }



    /**
     * Get user profile relative path
     *
     * @param string $imagePath
     * @return string
     */
    public static function getUserProfileRelativePath(string $imagePath = ''): string
    {
        return self::getUserProfileFolder().($imagePath != '' ? DIRECTORY_SEPARATOR.$imagePath : '');
    }


    /**
     * Get lead document absolute path
     *
     * @param string $imagePath
     * @return string
     */
    public static function getUserProfileAbsolutePath(string $imagePath = ''): string
    {
        return Storage::disk('public')->path(self::getUserProfileRelativePath($imagePath));
    }





    /**
     * Get Lead Document Folder
     *
     * @return string
     */
    public static function getLeadDocumentFolder(): string
    {
        return config('buch.lead_document_storage_folder');
    }

    /**
     * Get Lead Document Extensions
     *
     * @return array
     */
    public static function getLeadDocumentExtensions(): array
    {
        return config('buch.lead_document_extensions');
    }

    /**
     * Get Lead Document Extensions
     *
     * @return int
     */
    public static function getLeadDocumentMaxSize(): int
    {
        return config('buch.lead_document_max_size');
    }

    /**
     * Get lead document relative path
     *
     * @param string $imagePath
     * @return string
     */
    public static function getLeadDocumentRelativePath(string $imagePath = ''): string
    {
        return self::getLeadDocumentFolder().($imagePath != '' ? DIRECTORY_SEPARATOR.$imagePath : '');
    }

    /**
     * Get lead document absolute path
     *
     * @param string $imagePath
     * @return string
     */
    public static function getLeadDocumentAbsolutePath(string $imagePath = ''): string
    {
        return Storage::path(self::getLeadDocumentRelativePath($imagePath));
    }




}