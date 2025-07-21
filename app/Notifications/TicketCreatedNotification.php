<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Slack\SlackMessage;
use Illuminate\Notifications\Notification;

class TicketCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly array $data = [])
    {
    }

    public function via(object $notifiable): array
    {
        return ['slack'];
    }

    public function toSlack(object $notifiable): SlackMessage
    {
        $message = ":warning: Ticket created\n\n";

        $message .= sprintf("User: *%s*\n", $this->data['user']);
        $message .= sprintf("Ticket: *%d*\n", $this->data['ticket_id']);
        $message .= sprintf("Channel: *%s*\n", $this->data['channel']);
        $message .= sprintf("Subject: *%s*\n", $this->data['subject']);
        $message .= sprintf("Category: *%s*", $this->data['category_name']);

        return (new SlackMessage())->text($message);
    }
}
