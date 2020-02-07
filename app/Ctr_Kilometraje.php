<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ctr_Kilometraje extends Model
{
    protected $table = 'vh_ctr_kilometraje';
    protected $dateFormat = 'Ymd H:i';
    public $timestamps = false;
}
