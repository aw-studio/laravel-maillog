<?php

namespace AwStudio\Maillog\Listeners;

use AwStudio\Maillog\LogRecord;
use Illuminate\Mail\Events\MessageSent;

class LogSentMailListener
{
    public function handle(MessageSent $event)
    {
        if (! in_array('sent', config('maillog.logs'))) {
            return;
        }

        (new LogRecord($event->message, 'sent'))->save();
    }
}
