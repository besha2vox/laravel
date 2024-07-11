<?php

namespace App\Enums\Permissions;

enum Account: string
{
    case EDIT = 'edit account';
    case DELETE = 'delete account';

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
