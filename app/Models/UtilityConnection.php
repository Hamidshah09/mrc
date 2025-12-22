<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilityConnection extends Model
{
    protected $fillable = [
        'mousque_id',
        'utility_type',
        'reference_number',
        'benificiary_type',
    ];

    public function mousque()
    {
        return $this->belongsTo(Mousque::class);
    }
}

