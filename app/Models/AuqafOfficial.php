<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuqafOfficial extends Model
{
    protected $fillable = [
        'mousque_id',
        'cnic',
        'name',
        'father_name',
        'position',
        'type',
        'profile_image',
        'contact_number',
    ];
    public function mousque()
    {
        return $this->belongsTo(Mousque::class, 'mousque_id');
    }

    public const POSITIONS = [
        1 => 'Khateeb',
        2 => 'Moazzin',
        3 => 'Khadim',
    ];

    /**
     * Accessor: returns human-readable position name
     */
    public function getPositionNameAttribute(): string
    {
        return self::POSITIONS[$this->position] ?? 'Unknown';
    }

}
