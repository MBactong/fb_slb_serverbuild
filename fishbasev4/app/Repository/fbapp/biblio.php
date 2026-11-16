<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class biblio extends Model
{
    protected $table = 'biblio';
    public $incrementing = false;
    protected $keyType = 'string';
}
