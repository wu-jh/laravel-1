<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    public $timestamps = true;
    protected $table = 'goods';
    protected $dateFormat = 'U';
    protected $casts = array('created_at' => 'created_at','updated_at'=>'updated_at');
}
