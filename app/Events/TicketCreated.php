<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class TicketCreated
{
    use Dispatchable;

    public function __construct(
        public int $ticketId,
        public int $userId,
    ) {
    }
}
