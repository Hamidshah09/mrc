<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DivorceHearing extends Model
{
    protected $fillable = [
        'divorce_case_id',
        'notice_number',
        'notice_date',
        'hearing_date',
        'status',
        'next_hearing_date',
        'proceeding_path',
        'remarks',
    ];

    protected $casts = [
        'notice_date' => 'date',
        'hearing_date' => 'date',
        'next_hearing_date' => 'date',
    ];

    public function divorceCase(): BelongsTo
    {
        return $this->belongsTo(DivorceCase::class);
    }

    public function getEffectiveHearingDateAttribute()
    {
        return $this->next_hearing_date ?: $this->hearing_date;
    }

    public function isCompleted(): bool
    {
        return $this->status === 'heard';
    }
}
