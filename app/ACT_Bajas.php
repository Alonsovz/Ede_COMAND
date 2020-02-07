<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ACT_Bajas extends Model
{
    protected $table = 'act_bajas_activos';
    public $timestamps = false;
    protected $dateFormat = 'Ymd H:i';
}
