<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArmsHistory extends Model
{
    protected $table = 'arms_history';

    protected $fillable = [
        'arms_license_id',
        'user_id',
        'action',
    ];

    public function armsLicense()
    {
        return $this->belongsTo(ArmsLicense::class, 'arms_license_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
