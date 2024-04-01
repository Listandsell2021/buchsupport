<?php

namespace App\DataHolders\Enum;

enum SettingType: string
{
    case string = 'String';
    case integer = 'Number';
    case float = 'Float';
    case array = 'Array';
    case boolean = 'Boolean';


    public static function all(): array
    {
        $types = [];
        foreach (self::cases() as $case) {
            $types[$case->name] = $case->value;
        }
        return $types;
    }

    public static function onlyNames(): array
    {
        $types = [];
        foreach (self::cases() as $case) {
            $types[] = $case->name;
        }
        return $types;
    }

}
