<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class districts extends Model
{
    protected $connection = 'remote_mysql';
    protected $fillable = ['name', 'Pro_id'];

    
}
