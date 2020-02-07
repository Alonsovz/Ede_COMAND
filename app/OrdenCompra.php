<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    public $dateFormat = 'Ymd H:i';
    protected $table = 'ordenes_compras';
}
