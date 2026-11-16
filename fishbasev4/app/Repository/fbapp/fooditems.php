<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class fooditems extends Model
{
    protected $table = 'fooditems';
    public $incrementing = false;
    protected $keyType = 'string';
}
