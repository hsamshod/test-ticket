<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\Events\TicketCreated;
use App\Models\Ticket;

class TicketService
{
    public function create(CreateTicketDTO $dto): void
    {
        try {
            \DB::beginTransaction();

            $ticket = Ticket::create($dto->toTicketData());
            $ticket->messages()->create($dto->toTicketMessageData($ticket->id));

            \DB::commit();

            event(new TicketCreated($ticket->id, $dto->sender_id));
        } catch (\Exception $exception) {
            \DB::rollback();

            \Log::error('Some handler for exception', [
                'message' => $exception->getMessage(),
            ]);
        }
    }
}