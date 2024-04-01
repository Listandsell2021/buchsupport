<?php

namespace App\DataHolders\Enum;

enum Membership: string
{
    case bronze = 'Bronze';
    case silver = 'Silver';
    case gold = 'Gold';
    case gold_plus = 'Gold Plus';


    public static function all(): array
    {
        $memberships = [];
        foreach (self::cases() as $case) {
            $memberships[$case->name] = $case->value;
        }
        return $memberships;
    }

    public static function onlyNames(): array
    {
        $memberships = [];
        foreach (self::cases() as $case) {
            $memberships[] = $case->name;
        }
        return $memberships;
    }


    public static function onlyValues(): array
    {
        $memberships = [];
        foreach (self::cases() as $case) {
            $memberships[] = __($case->value);
        }
        return $memberships;
    }


    /**
     * Get for Select Plugins
     *
     * @return array
     */
    public static function getForSelect(): array
    {
        $memberships = [];
        foreach (self::cases() as $case) {
            $memberships[] = [
                'id' => $case->name,
                'name' => __($case->value)
            ];
        }
        return $memberships;
    }

    public static function order(): array
    {
        return [self::gold_plus->name, self::gold->name, self::silver->name, self::bronze->name];
    }

}
