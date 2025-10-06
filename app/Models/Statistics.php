<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $fillable = [
        'center_id',
        'service_id',
        'service_count',
        'report_date',
    ];

    // ✅ Relation with Centers model (plural class)
    public function center()
    {
        return $this->belongsTo(\App\Models\Centers::class, 'center_id');
    }

    // ✅ Relation with Services model (plural class)
    public function service()
    {
        return $this->belongsTo(\App\Models\Services::class, 'service_id');
    }

    // optional (if you ever use center_services pivot)
    public function centerServices()
    {
        return $this->belongsTo(\App\Models\centerServices::class, 'center_service_id');
    }
}
