<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NocOtherDistrictApplicants extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'noc_applicants';
    protected $primaryKey = 'App_ID';
    public $timestamps = false;

    protected $fillable = [
        'Letter_ID',
        'Applicant_Name',
        'Applicant_FName',
        'CNIC',
        'Relation'
    ];

    public function letter(){
        return $this->belongsTo(NocOtherDistrict::class, 'Letter_ID', 'Letter_ID');
    }
}
