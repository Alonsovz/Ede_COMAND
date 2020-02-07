<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VH_Vehiculos extends Model
{
    public $dateFormat = 'Ymd';
    public $timestamps = false;
    protected $table = 'Vh_vehiculos';
}
