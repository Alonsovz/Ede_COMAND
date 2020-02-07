<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoInsumo extends Model
{
    public $timestamps = false;
    public $dateFormat = 'Ymd';
    protected $table = 'movimientos_insumos';
}
