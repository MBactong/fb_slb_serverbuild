<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class occurrence extends Model
{
   protected $table = 'occurrence';
    public $incrementing = false;
    protected $keyType = 'string';
}
