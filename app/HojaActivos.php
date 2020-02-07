<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HojaActivos extends Model
{
    public $dateformat = 'Ymd H:i';
    protected $table = 'hojas_activos';
    public $timestamps=false;
}
