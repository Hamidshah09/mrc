<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostalService extends Model
{
    protected $fillable = [
        'article_number',
        'receiver_name',
        'receiver_address',
        'phone_number',
        'weight',
        'rate',
        'status_id',
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
    
}
