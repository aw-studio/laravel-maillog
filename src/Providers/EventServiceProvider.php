<?php

namespace AwStudio\Maillog\Providers;

use AwStudio\Maillog\Listeners\LogSendingMailListener;
use AwStudio\Maillog\Listeners\LogSentMailListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        MessageSent::class => [
            LogSentMailListener::class,
        ],
        MessageSending::class => [
            LogSendingMailListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
