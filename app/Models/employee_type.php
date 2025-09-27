<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employee_type extends Model
{
    public $timestamps = false;
    public function employees(){
        return $this->hasMany(employee::class, 'emp_type_id', 'id');
    }
}
