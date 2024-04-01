<?php

namespace App\DataHolders\Enum;

enum MembershipPackage: string
{
    case premium = 'premium';
    case standard = 'standard';
    case basic = 'basic';

    static function names(): array
    {
        return [self::premium->name, self::standard->name, self::basic->name];
    }

    static function getSelectInputData(): array
    {
        return [
            [
                'label' => 'Basic',
                'value' => self::basic->name
            ],
            [
                'label' => 'Standard',
                'value' => self::standard->name
            ],
            [
                'label' => 'Premium',
                'value' => self::premium->name
            ]
        ];
    }
}
