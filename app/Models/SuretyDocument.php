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
        'entered_entries'
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
        return $this->hasMany(SuretyRegister::class);
    }
}
