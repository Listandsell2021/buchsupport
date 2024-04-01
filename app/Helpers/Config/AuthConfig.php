<?php

namespace App\Helpers\Config;

use Illuminate\Support\Facades\Storage;

class AuthConfig
{

    public static function getAdminGuard(): string
    {
        return 'admin';
    }

    public static function getSalespersonGuard(): string
    {
        return 'salesperson';
    }

    public static function getCustomerGuard(): string
    {
        return 'web';
    }


    public static function getAdminId(): int
    {
        return (int) auth(self::getAdminGuard())->id();
    }

    public static function getSalespersonId(): int
    {
        return (int) auth(self::getSalespersonGuard())->id();
    }

    public static function getCustomerId(): int
    {
        return (int) auth(self::getCustomerGuard())->id();
    }



}