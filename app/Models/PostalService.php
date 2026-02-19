<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostalService extends Model
{
    protected $fillable = [
        'article_number',
        'receiver_name',
        'receiver_address',
        'receiver_city_id',
        'phone_number',
        'weight',
        'rate',
        'status_id',
        'service_id',
        'user_id',
    ];
    protected $table = 'postalservice';
    public function status()
    {
        return $this->belongsTo(PostalStatuses::class);
    }
    
    public function history()
    {
        return $this->hasMany(PostalHistory::class, 'postalservice_id');
    }
    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'receiver_city_id');
    }
    
}
