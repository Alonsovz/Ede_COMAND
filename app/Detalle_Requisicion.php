<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_Requisicion extends Model
{
    public $timestamps = false;
    public $dateformat = 'Ymd';
    protected $table = 'requisicion_detalles';

}
