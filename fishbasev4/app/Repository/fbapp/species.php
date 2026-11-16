<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class species extends Model
{
    protected $table = 'species';
    public $incrementing = false;
    protected $keyType = 'string';
}
