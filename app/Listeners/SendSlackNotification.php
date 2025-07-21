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
        $user = User::findOrFail($event->userId);

        \Notification::route('slack', config('services.slack.notifications.bot_webhook_token'))
            ->notify(new TicketCreatedNotification([
                'user' => sprintf('%s (%s) ', $user->name, $user->email),
                'ticket_id' => $ticket->id,
                'channel' => $ticket->channel,
                'subject' => $ticket->subject,
                'category_name' => $ticket->category->name,
            ]));
    }
}
