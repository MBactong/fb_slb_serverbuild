<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class searchpagestats extends Model
{
   protected $table = 'searchpagestats';
    public $incrementing = false;
    protected $keyType = 'string';
}