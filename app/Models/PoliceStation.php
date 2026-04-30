<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoliceStation extends Model
{
    protected $table = 'policestations';

    protected $fillable = [
        'name',
    ];
    public function suretyRegisters()
    {
        return $this->hasMany(SuretyRegister::class, 'police_station_id');
    }
}

