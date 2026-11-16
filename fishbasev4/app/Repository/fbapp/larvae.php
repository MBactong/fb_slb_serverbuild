<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class larvae extends Model
{
    protected $table = 'larvae';
    public $incrementing = false;
    protected $keyType = 'string';
}
