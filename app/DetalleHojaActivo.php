<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleHojaActivo extends Model
{
    public $timestamps = false;
    public $dateformat = 'Ymd';

    protected  $table = 'detalles_hoja_activo';
}
