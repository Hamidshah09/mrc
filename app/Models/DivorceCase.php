<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mattiverse\Userstamps\Traits\Userstamps;

class DivorceCase extends Model
{
    use Userstamps;

    protected $fillable = [
        'entry_type',
        'case_no',
        'divorce_type',
        'applicant_side',
        'groom_cnic',
        'groom_name',
        'groom_father_name',
        'groom_address',
        'bride_cnic',
        'bride_name',
        'bride_father_name',
        'bride_address',
        'decision_date',
        'issue_date',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'decision_date' => 'date',
        'issue_date' => 'date',
    ];

    public function hearings(): HasMany
    {
        return $this->hasMany(DivorceHearing::class)->orderBy('notice_number');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusAttribute(): string
    {
        if ($this->issue_date) {
            return 'Certificate Issued';
        }

        if ($this->allHearingsCompleted()) {
            return 'Ready for Certificate';
        }

        return 'Under Arbitration';
    }

    public function allHearingsCompleted(): bool
    {
        $hearings = $this->relationLoaded('hearings') ? $this->hearings : $this->hearings()->get();

        return $hearings->count() === 3 && $hearings->every(fn (DivorceHearing $hearing) => $hearing->isCompleted());
    }
}
