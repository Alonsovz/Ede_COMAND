<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsumoCentroCostos extends Model
{
    public $timestamps = false;
    public $dateFormat = 'Ymd';
    protected $table = 'insumos-centro_costos';
}
