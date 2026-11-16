<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class estimate extends Model
{
    protected $table = 'estimate';
    public $incrementing = false;
    protected $keyType = 'string';
}
