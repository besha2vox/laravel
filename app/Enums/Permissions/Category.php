<?php

namespace App\Enums\Permissions;

use Illuminate\Database\Eloquent\Factories\HasFactory;

enum Category: string
{

    use HasFactory;

    case PUBLISH = 'publish category';
    case EDIT = 'edit category';
    case DELETE = 'delete category';

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
