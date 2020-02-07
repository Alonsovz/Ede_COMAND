<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    public $dateFormat = 'Ymd';
    public $timestamps = false;
    protected $table = 'insumos';
}
