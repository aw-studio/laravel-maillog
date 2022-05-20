<?php

namespace AwStudio\Maillog\Listeners;

use AwStudio\Maillog\LogRecord;
use Illuminate\Mail\Events\MessageSent;

class LogSentMailListener
{
    public function handle(MessageSent $event)
    {
        (new LogRecord($event->message))->save();
    }
}
