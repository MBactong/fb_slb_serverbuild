<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class strains extends Model
{
    protected $table = 'strains';
    public $incrementing = false;
    protected $keyType = 'string';
}
