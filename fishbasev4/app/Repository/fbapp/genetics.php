<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class genetics extends Model
{
    protected $table = 'genetics';
    public $incrementing = false;
    protected $keyType = 'string';
}
