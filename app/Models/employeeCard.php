<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employeeCard extends Model
{
    public $guarded = [];
    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
