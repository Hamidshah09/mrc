<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class children extends Model

{
    protected $connection = 'remote_mysql';
    protected $table = 'children';
    protected $guarded = [];
    public $timestamps = false;
    // protected $casts = ['date_of_birth'=>'date'];

    public function domicileApplicants(){
        return $this->belongsTo(DomicileApplicants::class, 'applicant_id', 'id');
    }
}
