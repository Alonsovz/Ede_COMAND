<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poste extends Model
{
    protected $table = 'sol_postes';
    public $timestamps = false;
    protected $dateFormat = 'Ymd H:i';
}
