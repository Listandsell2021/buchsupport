<?php

namespace App\DataHolders\Enum;

enum PipelineSortingEvent: string
{
    case remove = 'Remove';
    case add = 'Add';


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
