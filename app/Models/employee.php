<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    public $guarded=[];
    public function designations()
    {
        return $this->belongsTo(designation::class, 'designation_id', 'id');
    }
    public function departments()
    {
        return $this->belongsTo(department::class, 'department_id', 'id');
    }
    public function employee_types()
    {
        return $this->belongsTo(employee_type::class, 'emp_type_id', 'id');
    }
}
