<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CRM_eventos extends Model
{
    protected $table = 'CRM_eventos';
    protected $dateFormat = 'Ymd H:i';
    public $timestamps = false;

}
