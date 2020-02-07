<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BitacoraActualizacionIns extends Model
{
    protected $table = 'bitacora_actualizacion_ins';
    protected $dateFormat = 'Ymd H:i';
    public $timestamps = false;
}
