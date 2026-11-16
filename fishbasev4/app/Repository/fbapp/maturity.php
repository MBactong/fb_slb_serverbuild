<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class maturity extends Model
{
    protected $table = 'maturity';
    public $incrementing = false;
    protected $keyType = 'string';
}
