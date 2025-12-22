<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'mousque_id',
        'occupier_name',
        'shop_description',
        'rent_amount',
        'shop_image',
    ];

    public function mousque()
    {
        return $this->belongsTo(Mousque::class);
    }
}

