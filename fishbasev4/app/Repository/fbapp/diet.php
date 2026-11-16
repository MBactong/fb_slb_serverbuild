<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class diet extends Model
{
    protected $table = 'diet';
    public $incrementing = false;
    protected $keyType = 'string';
}
