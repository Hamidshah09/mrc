<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDivision extends Model
{
    protected $fillable = [
        'name',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function policeStations()
    {
        return $this->hasMany(PoliceStation::class, 'sub_division_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function acs()
    {
        return $this->hasMany(User::class, 'sub_division_id');
    }
}