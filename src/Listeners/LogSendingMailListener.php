<?php

namespace AwStudio\Maillog\Listeners;

use AwStudio\Maillog\LogRecord;
use Illuminate\Mail\Events\MessageSending;

class LogSendingMailListener
{
    public function handle(MessageSending $event)
    {
        (new LogRecord($event->message))->save();
    }
}
