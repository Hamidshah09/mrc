<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomicileApplicants extends Model
{
    protected $guarded=[];
    public $table = 'domicileapplicants';
    public function children(){
        return $this->hasMany(children::class, 'applicant_id', 'id');
    }
    public function marital_statuses(){
        return $this->belongsTo(marital_status::class, 'marital_status_id', 'id');
    }
    public function occupations(){
        return $this->belongsTo(occupation::class, 'occupation_id', 'id');
    }
}
