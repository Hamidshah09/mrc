<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{   
    const STATUS_PENDING = 'pending';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_DISPOSED = 'disposed';
    protected $fillable = [

        'operator_id',
        'ac_id',
        'magistrate_id',

        'sub_division_id',
        'policestation_id',

        'before_image',
        'after_image',

        'latitude',
        'longitude',
        'google_map_link',

        'operator_remarks',
        'magistrate_remarks',
        'ac_remarks',
        'admin_remarks',

        'status',

        'assigned_at',
        'resolved_at',
        'approved_at',
        'disposed_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'resolved_at' => 'datetime',
        'approved_at' => 'datetime',
        'disposed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function ac()
    {
        return $this->belongsTo(User::class, 'ac_id');
    }

    public function magistrate()
    {
        return $this->belongsTo(User::class, 'magistrate_id');
    }

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }

    public function policeStation()
    {
        return $this->belongsTo(PoliceStation::class, 'policestation_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isPending()
    {
        return $this->status == 'pending';
    }

    public function isAssigned()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isResolved()
    {
        return $this->status == 'resolved';
    }

    public function isApproved()
    {
        return $this->status == 'approved';
    }

    public function isRejected()
    {
        return $this->status == 'rejected';
    }

    public function isDisposed()
    {
        return $this->status == 'disposed';
    }
}