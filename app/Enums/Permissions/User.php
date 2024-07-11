<?php

namespace App\Enums\Permissions;

enum User: string
{
    case EDIT = 'edit user';
    case DELETE = 'delete user';

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
