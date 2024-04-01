<?php

namespace App\DataHolders\Enum;

enum CallUserType: string
{
    case delete_product = 'Delete Product';
    case update_product = 'Update Product';
    case help = 'Help';
    case buy_product = 'Buy Product';
    case new_product = 'New Product';

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


    public static function onlyValues(): array
    {
        $data = [];
        foreach (self::cases() as $case) {
            $data[] = $case->value;
        }
        return $data;
    }

}
