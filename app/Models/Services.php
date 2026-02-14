<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $fillable = ['service'];
     public function centerServices()
    {
        return $this->hasMany(centerServices::class);
    }

    public function centers()
    {
        return $this->belongsToMany(Centers::class, 'center_services');
    }
    public function postalServices()
    {
        return $this->hasMany(PostalService::class, 'service_id');
    }
}
