<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class sounds extends Model
{
    protected $table = 'sounds';
    public $incrementing = false;
    protected $keyType = 'string';
}
