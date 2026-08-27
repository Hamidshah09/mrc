<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropTemplate extends Model
{
    protected $fillable = [
        'field_name',
        'x',
        'y',
        'width',
        'height',
    ];

}