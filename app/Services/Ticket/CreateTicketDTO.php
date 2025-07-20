<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\Enums\Ticket\Channel;
use App\Enums\Ticket\SenderType;
use App\Enums\Ticket\Status;
use App\Http\Requests\CreateTicketRequest;

readonly class CreateTicketDTO
{
    private function __construct(
        public int $category_id,
        public string $subject,
        public string $message,
        public Channel $channel,
        public Status $status,
        public int $sender_id,
        public SenderType $sender_type,
    ) {
    }

    public static function fromRequest(CreateTicketRequest $request): self
    {
        $data = $request->validated();
        return new self(
            $data['category_id'],
            $data['subject'],
            $data['message'],
            Channel::WEB,
            Status::NEW,
            $request->user()->id,
            SenderType::USER,
        );
    }

    public static function fromTelegram(array $data): self
    {
        return new self(
            $data['category_id'],
            $data['subject'],
            $data['message'],
            Channel::TLGM,
            Status::NEW,
            $data['user_id'],
            SenderType::USER,
        );
    }

    public function toTicketData(): array
    {
        return [
            'category_id' => $this->category_id,
            'subject' => $this->subject,
            'channel' => $this->channel->value,
            'status' => $this->status->value,
        ];
    }

    public function toTicketMessageData(int $ticketId): array
    {
        return [
            'ticket_id' => $ticketId,
            'sender_id' => $this->sender_id,
            'sender_type' => $this->sender_type->value,
            'message' => $this->message,
        ];
    }
}