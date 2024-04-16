<?php

namespace App\DataHolders\Enum;

enum OrderStatus: string
{
    case paid = 'Paid';
    case rescued = 'Tried Rescue';
    case cancelled = 'Cancelled';

    public static function all(): array
    {
        $data = [];
        foreach (self::cases() as $case) {
            $data[$case->name] = $case->value;
        }
        return $data;
    }

    public static function onlyNames(): array
    {
        $data = [];
        foreach (self::cases() as $case) {
            $data[] = $case->name;
        }
        return $data;
    }

    public static function forSelectOptions(): array
    {
        $data = [];
        foreach (self::cases() as $case) {
            $data[] = [
                'id' => $case->name,
                'name' => $case->value
            ];
        }
        return $data;
    }



}
