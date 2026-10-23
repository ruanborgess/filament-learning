<?php

namespace App\Enum;

enum Role: string
{
    case Admin = 'admin';
    case Subscriber = 'user';
    case Editor = 'editor';

    
    public static function values(): array
    {
       return array_column(self::cases(), 'value');
    }
}
