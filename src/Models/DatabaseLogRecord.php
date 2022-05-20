<?php

namespace AwStudio\Maillog\Models;

use Illuminate\Database\Eloquent\Model;

class DatabaseLogRecord extends Model
{
    protected $table = 'mail_logs';

    protected $guarded = [];
}
