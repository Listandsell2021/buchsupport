<?php

namespace App\DataHolders\Enum;

enum NotificationTypes: string
{
    case lead_new_customer = 'New Customer';

    public static function all(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->name] = $case->value;
        }
        return $array;
    }

    public static function onlyNames(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[] = $case->name;
        }
        return $array;
    }

}
