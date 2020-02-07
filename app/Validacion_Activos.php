<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Validacion_Activos extends Model
{
    protected $table = 'validacion_activos';
    public $timestamps = false;
    protected $dateFormat = 'Ymd H:i';
}
