<?php

namespace App\Repository\fbwebwritev4;

use Illuminate\Database\Eloquent\Model;

class announcement extends Model
{
   protected $table = 'announcement';
   public $incrementing = false;
   protected $keyType = 'string';
   protected $connection = 'mysql2';
    
}
