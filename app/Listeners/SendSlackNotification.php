<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSlackNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(TicketCreated $event): void
    {
        $ticket = Ticket::findOrFail($event->ticketId);
        $user = User::find($event->userId);

        \Notification::route('slack', config('slack.notifications.ticket'))
            ->notify(new TicketCreatedNotification([
                'user' => sprintf('%s (%s) ', $user->name, $user->email),
                'ticket_id' => $ticket->id,
                'channel' => $ticket->channel,
                'subject' => $ticket->subject,
                'category' => $ticket->category->name,
            ]));
    }
}
