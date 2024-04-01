<?php

namespace App\DataHolders\Enum;

enum LeadActivityType: string
{
    case lead_note_created = 'Lead note created';
    case lead_note_updated = 'Lead note updated';
    case lead_note_deleted = 'Lead note deleted';
    case lead_status_changed = 'Lead status changed';
    case lead_status_removed = 'Lead status removed';
    case lead_created = 'New lead created';
    case event = 'Event';

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
