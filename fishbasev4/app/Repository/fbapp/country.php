<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    protected $table = 'country';
    public $incrementing = false;
    protected $keyType = 'string';
}
