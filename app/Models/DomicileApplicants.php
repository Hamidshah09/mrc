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
}
