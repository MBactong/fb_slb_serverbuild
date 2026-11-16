<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class eggs extends Model
{
    protected $table = 'eggs';
    public $incrementing = false;
    protected $keyType = 'string';
}
