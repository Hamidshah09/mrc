<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MousqueImage extends Model
{
    protected $fillable = [
        'mousque_id',
        'image_path',
    ];

    public function mousque()
    {
        return $this->belongsTo(Mousque::class);
    }

}
