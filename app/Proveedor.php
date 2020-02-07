<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    public $dateFormat = 'Ymd';
    protected $table = 'proveedores';
}
