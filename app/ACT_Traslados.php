<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ACT_Traslados extends Model
{
    protected $table = 'act_traslados';
    protected $dateFormat = 'Ymd H:i';
    public $timestamps = false;
}
