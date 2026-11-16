<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class synonyms extends Model
{
    protected $table = 'synonyms';
    public $incrementing = false;
    protected $keyType = 'string';
}

