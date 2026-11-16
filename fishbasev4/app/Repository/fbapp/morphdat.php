<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class morphdat extends Model
{
   protected $table = 'morphdat';
    public $incrementing = false;
    protected $keyType = 'string';
}
