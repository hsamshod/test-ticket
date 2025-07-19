<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\TicketCreated;
use App\Listeners\SendSlackNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        TicketCreated::class => [SendSlackNotification::class],
    ];
}
