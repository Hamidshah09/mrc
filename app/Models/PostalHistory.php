<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostalHistory extends Model
{
    protected $table = 'postalhistory';
    protected $fillable = [
        'postalservice_id',
        'status_id',
        'user_id',
    ];
    public function postalservice()
    {
        return $this->belongsTo(PostalService::class, 'postalservice_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
