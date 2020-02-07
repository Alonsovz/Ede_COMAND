<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VH_Reserva extends Model
{
    public $timestamps = false;
    protected $table = 'vh_reservas';
    public $dateFormat = 'Ymd H:i';

}
