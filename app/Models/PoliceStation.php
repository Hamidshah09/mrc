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

      public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }

    public function magistrates()
    {
        return $this->hasMany(User::class, 'policestation_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'policestation_id');
    }
}

