<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostalStatuses extends Model
{
    protected $table = 'postalstatuses';
    public function postalservices()
    {
        return $this->hasMany(PostalService::class, 'status_id');
    }
}
