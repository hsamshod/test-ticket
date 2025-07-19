<?php

declare(strict_types=1);

namespace App\Enums\Ticket;

enum SenderType: string
{
    case ADMIN = 'admin';
    case USER = 'user';
}