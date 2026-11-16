<?php

namespace App\Repository\fbapp;

use Illuminate\Database\Eloquent\Model;

class collaborators extends Model
{
   protected $table = 'collaborators';
    public $incrementing = false;
    protected $keyType = 'string';
}
