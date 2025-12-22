<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maddarsa extends Model
{
    protected $fillable = [
        'mousque_id',
        'name',
        'no_of_students',
        'mohtamim_name',
    ];

    public function mousque()
    {
        return $this->belongsTo(Mousque::class);
    }
}

