<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VH_Mantenimiento extends Model
{
    public $timestamps=false;
    protected $table='vh_mantenimientos';
    protected $dateFormat='Ymd H:i';
}
