<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SuretyStatus;
use App\Models\SuretyRegister;
use App\Models\User;

class SuretyHistory extends Model
{
    protected $table = 'suretyhistory';
    protected $fillable = [
        'surety_id',
        'status_id',
        'updated_by',
    ];
    public function surety()
    {
        return $this->belongsTo(SuretyRegister::class, 'surety_id');
    }

    public function status()
    {
        return $this->belongsTo(SuretyStatus::class, 'status_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
