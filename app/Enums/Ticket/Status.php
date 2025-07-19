<?php

declare(strict_types=1);

namespace App\Enums\Ticket;

enum Status: string
{
    case INCOMPLETE = 'incomplete';
    case NEW = 'new';
    case PENDING = 'pending';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';

    public static function values(): array
    {
        return [
            self::INCOMPLETE->value,
            self::NEW->value,
            self::PENDING->value,
            self::RESOLVED->value,
            self::CLOSED->value,
        ];
    }
}