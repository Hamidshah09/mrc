<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centers extends Model
{
    protected $fillable = ['center'];
     // each center has many center_service records
    public function centerServices()
    {
        return $this->hasMany(centerServices::class);
    }

    // optional: direct services via pivot (handy)
    public function services()
    {
        return $this->belongsToMany(Services::class, 'center_services');
    }

    public function statistics(){
        return $this->hasMany(Statistics::class, 'center_id');
    }
}
