<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuretyImage extends Model
{
    protected $table = 'surety_images';
    protected $fillable = [
        'surety_register_id',
        'path',
        'original_name',
    ];

    public function surety()
    {
        return $this->belongsTo(SuretyRegister::class, 'surety_register_id');
    }
}
