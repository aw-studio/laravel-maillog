<?php

namespace AwStudio\Maillog;

use AwStudio\Maillog\Models\DatabaseLogRecord;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class LogRecord
{
    /**
     * The logged event, e.g. 'sent'.
     *
     * @var string
     */
    protected $type;

    /**
     * The recipient(s) of the mail.
     *
     * @var string
     */
    protected $to;

    /**
     * The mail subject.
     *
     * @var string
     */
    protected $subject;

    public function __construct($message, string $logType = 'sent')
    {
        $this->type = $logType;

        $this->subject = $message->getSubject();

        if ($message instanceof \Swift_Message) {
            $this->to = implode(
                ',',
                $message->getHeaders()
                    ->get('to')
                    ->getAddresses()
            );
        } else {
            $this->to = implode(
                ',',
                array_map(function (\Symfony\Component\Mime\Address $address) {
                    return $address->getAddress();
                }, $message->getHeaders()->get('to')->getAddresses())
            );
        }
    }

    /**
     * Save the LogRecord to the configured channels.
     *
     * @return void
     */
    public function save()
    {
        if (in_array('log', Config::get('maillog.channels'))) {
            $this->logToFile();
        }

        if (in_array('database', Config::get('maillog.channels'))) {
            $this->logToDatabase();
        }
    }

    /**
     * Log the record to file.
     *
     * @return void
     */
    protected function logToFile()
    {
        Log::channel('maillog')
            ->info($this);
    }

    /**
     * Log record to database.
     *
     * @return void
     */
    protected function logToDatabase()
    {
        try {
            DatabaseLogRecord::create([
                'type' => $this->type,
                'to' => $this->to,
                'subject' => $this->subject,
            ]);
        } catch (\Throwable $th) {
            Log::error('Unable to log to Database. Using fallback log to file. ', [
                $th->getMessage(),
            ]);
            $this->logToFile();
        }
    }

    /**
     * Return a string representation of the LogRecord object.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(get_object_vars($this));
    }
}
