<?php

namespace App\DataHolders\Enum;

enum Gender: string
{
    case male = 'Male';
    case female = 'Female';

    public static function all(): array
    {
        $genders = [];
        foreach (self::cases() as $case) {
            $genders[$case->name] = $case->value;
        }
        return $genders;
    }

    public static function onlyNames(): array
    {
        $genders = [];
        foreach (self::cases() as $case) {
            $genders[] = $case->name;
        }
        return $genders;
    }


    public static function onlyValues(): array
    {
        $genders = [];
        foreach (self::cases() as $case) {
            $genders[] = $case->value;
        }
        return $genders;
    }


}
