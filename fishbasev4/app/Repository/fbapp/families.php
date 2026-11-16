<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class families extends Model
{
    protected $table = 'families';
    public $incrementing = false;
    protected $keyType = 'string';
}