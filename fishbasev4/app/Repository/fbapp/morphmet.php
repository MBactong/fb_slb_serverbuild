<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class morphmet extends Model
{
    protected $table = 'morphmet';
    public $incrementing = false;
    protected $keyType = 'string';
}
