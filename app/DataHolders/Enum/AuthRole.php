<?php

namespace App\DataHolders\Enum;

enum AuthRole: string
{
    case super_admin = 'Super Admin';
    case admin = 'Admin';
    case salesperson = 'Salesperson';

    public static function all(): array
    {
        $roles = [];
        foreach (self::cases() as $case) {
            $roles[$case->name] = $case->value;
        }
        return $roles;
    }

    public static function onlyNames($skip = 0): array
    {
        $roles = [];
        foreach (self::cases() as $case) {
            $roles[] = $case->name;
        }
        return $roles;
    }

    public static function forSelectOptions(): array
    {
        $roles = [];
        foreach (self::cases() as $case) {

            if (!isAuthSuperAdmin() && $case->name == self::super_admin->name) {
                continue;
            }

            $roles[] = [
                'id' => $case->name,
                'name' => $case->value
            ];
        }
        return $roles;
    }

    public static function getSuperAdminRole(): string
    {
        return (AuthRole::super_admin)->name;
    }

    public static function getAdminRole(): string
    {
        return (AuthRole::admin)->name;
    }

    public static function getSalespersonRole(): string
    {
        return (AuthRole::salesperson)->name;
    }

}
