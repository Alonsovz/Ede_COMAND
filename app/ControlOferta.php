<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlOferta extends Model
{
    public $timestamps = false;
    protected $table = 'control_ofertas';
    protected $dateFormat = 'Ymd H:i';
}
