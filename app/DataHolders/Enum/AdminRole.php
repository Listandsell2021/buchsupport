<?php

namespace App\DataHolders\Enum;

enum AdminRole: string
{
    case admin = 'Admin';
    case employee = 'Employee';

    public static function all(): array
    {
        $roles = [];
        foreach (self::cases() as $case) {
            $roles[$case->name] = $case->value;
        }
        return $roles;
    }

    public static function onlyNames(): array
    {
        $roles = [];
        foreach (self::cases() as $case) {
            $roles[] = $case->name;
        }
        return $roles;
    }

    public static function getAdminRole(): string
    {
        return (AdminRole::admin)->name;
    }

    public static function getEmployeeRole(): string
    {
        return (AdminRole::employee)->name;
    }

}
