<?php

declare(strict_types=1);

namespace App\Enums\Ticket;

enum Channel: string
{
    case WEB = 'WEB';
    case TLGM = 'TLGM';

    public static function values(): array
    {
        return [
            self::WEB->value,
            self::TLGM->value,
        ];
    }
}