<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuretyDocument extends Model
{
    protected $table = 'suretydocuments';
    protected $fillable = [
        'file_path',
        'original_name',
        'uploaded_by',
        'locked_by',
        'locked_at',
        'status',
        'total_expected_entries',
        'entered_entries',
        'total_amount'
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function locker()
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    public function records()
    {
        return $this->hasMany(SuretyRegister::class, 'document_id');
    }

    /**
     * Sum of amounts from related SuretyRegister records.
     * Uses the eager-loaded `records_sum_amount` when present to avoid N+1 queries.
     */
    public function getTotalAmountSoFarAttribute()
    {
        if (array_key_exists('records_sum_amount', $this->attributes)) {
            return $this->attributes['records_sum_amount'];
        }

        return $this->records()->sum('amount');
    }
}
