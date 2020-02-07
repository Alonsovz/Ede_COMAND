<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    public $timestamps = false;
    protected $table = 'permisos';
    public $dateFormat = 'Ymd H:i';
}
