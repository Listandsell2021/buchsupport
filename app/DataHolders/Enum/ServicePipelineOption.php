<?php

namespace App\DataHolders\Enum;

enum ServicePipelineOption: string
{
    case paid = 'Paid';
    case rescued = 'Tried Rescue';
    case cancelled = 'Cancelled';

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
            $roles[] = [
                'id' => $case->name,
                'name' => $case->value
            ];
        }
        return $roles;
    }


    public static function default(): string
    {
        return self::paid->name;
    }

}
