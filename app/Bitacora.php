<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    //
    public $dateFormat = 'Ymd';
    public $table = 'bitacoras';
    public $timestamps =false;
}
