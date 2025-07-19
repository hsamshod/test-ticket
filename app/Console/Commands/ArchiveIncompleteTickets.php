<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Ticket\Status;
use App\Models\Ticket;
use Illuminate\Console\Command;

class ArchiveIncompleteTickets extends Command
{
    protected $signature = 'app:archive-incomlete-tickets';

    protected $description = 'Archives incomplete tickets';

    public function handle(): void
    {
        Ticket::query()
            ->where('status', Status::INCOMPLETE)
            ->where('updated_at', '<=', now()->subDay()) // also, we can add status_updated_at and use it instead of updated_at
            ->delete();
    }
}
