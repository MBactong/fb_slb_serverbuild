<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class stocks extends Model
{
    protected $table = 'stocks';
    public $incrementing = false;
    protected $keyType = 'string';
}
