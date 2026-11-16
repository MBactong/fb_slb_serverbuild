<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class acknowledge extends Model
{
    protected $table = 'acknowledge';
    public $incrementing = false;
    protected $keyType = 'string';
}
