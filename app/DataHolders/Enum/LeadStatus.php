<?php

namespace App\DataHolders\Enum;

enum LeadStatus: string
{
    case processing = 'Processing';
    case on_hold = 'On Hold';
    case new_customer = 'New Customer';
    case rejected = 'Rejected';

    public static function all(): array
    {
        $status = [];
        foreach (self::cases() as $case) {
            $status[$case->name] = $case->value;
        }
        return $status;
    }

    public static function forSelectOption(): array
    {
        $status = [];
        foreach (self::cases() as $case) {
            $status[] = [
                'id'   => $case->name,
                'name' => $case->value
            ];
        }
        return $status;
    }

    public static function onlyNames(): array
    {
        $status = [];
        foreach (self::cases() as $case) {
            $status[] = $case->name;
        }
        return $status;
    }

}
