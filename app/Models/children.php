<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class children extends Model
{
    protected $guarded = [];
    protected $casts = ['date_of_birth'=>'date'];
}
