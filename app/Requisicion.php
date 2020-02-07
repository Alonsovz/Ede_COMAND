<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requisicion extends Model
{
    public $dateFormat = 'Ymd';
    protected $table = 'requisiciones_insumos';
}
