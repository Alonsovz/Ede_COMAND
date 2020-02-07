<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketMessenger extends Model
{
    public $table = 'tickets_messenger';
    public $dateFormat = 'Ymd H:i';
    public $timestamps = false;

}
