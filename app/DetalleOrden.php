<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{

    public $timestamps = false;
    public $dateformat = 'Ymd';

    protected  $table = 'detalles_orden_compra';


}
