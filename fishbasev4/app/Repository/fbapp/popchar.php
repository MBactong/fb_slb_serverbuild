<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class popchar extends Model
{
    protected $table = 'popchar';
    public $incrementing = false;
    protected $keyType = 'string';
}
