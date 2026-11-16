<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class diseases extends Model
{
    protected $table = 'diseases';
    public $incrementing = false;
    protected $keyType = 'string';
}
