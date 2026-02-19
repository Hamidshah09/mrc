<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    protected $fillable = [
        'name',
    ];
    protected $table = 'cities';
    public $timestamps = false;
}
