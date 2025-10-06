<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CenterServices extends Model
{
    

    protected $table = 'center_services';
    protected $fillable = ['center_id', 'service_id', 'service_count'];
    public function center()
    {
        return $this->belongsTo(Centers::class);
    }

    public function service()
    {
        return $this->belongsTo(Services::class);
    }

    public function statistics()
    {
        return $this->hasMany(Statistics::class);
    }

    // convenience accessor
    public function getLabelAttribute()
    {
        return $this->center->name . ' — ' . $this->service->name;
    }
}
