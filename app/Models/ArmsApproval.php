<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArmsApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'applicant_id',
        'cnic',
        'name',
        'license_no',
        'weapon_no',
        'request_type',
        'action',
        'operator',
        'file_status',
        'url',
        'created_at',
        'updated_at',
    ];

    public $incrementing = false; // because we’re syncing IDs from remote
    protected $keyType = 'int';
}
