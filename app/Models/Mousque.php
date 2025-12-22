<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mousque extends Model
{
    protected $fillable = [
        'name',
        'address',
        'sector_id',
        'sub_sector',
        'location',
        'sect',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(MousqueImage::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    public function officials()
    {
        return $this->hasMany(AuqafOfficial::class);
    }

    public function maddarsa()
    {
        return $this->hasOne(Maddarsa::class);
    }

    public function utilities()
    {
        return $this->hasMany(UtilityConnection::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
}
