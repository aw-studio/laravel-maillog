<?php

namespace AwStudio\Maillog\Listeners;

use AwStudio\Maillog\LogRecord;
use Illuminate\Mail\Events\MessageSending;

class LogSendingMailListener
{
    public function handle(MessageSending $event)
    {
        if (! in_array('sending', config('maillog.logs'))) {
            return;
        }

        (new LogRecord($event->message, 'sending'))->save();
    }
}
