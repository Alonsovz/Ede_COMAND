<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpActivo extends Model
{
    protected $table = 'emp_activos';
    protected $dateFormat = 'Ymd';
    public $timestamps = false;
}
