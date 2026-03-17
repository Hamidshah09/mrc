<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NocOtherDistrict extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'noc_letters';
    protected $primaryKey = 'Letter_ID';
    public $timestamps = false;

    protected $fillable = [
        'referenced_letter_no', 
        'referenced_letter_date', 
        'Letter_Date', 
        'NOC_Issued_To', 
        'Remarks'
    ];

    public function applicants(){
        return $this->hasMany(NocOtherDistrictApplicants::class, 'Letter_ID', 'Letter_ID');
    }

    public function dispatchDiary(){
        return $this->hasOne(DispatchDiary::class, 'Letter_ID', 'Letter_ID')->where('Letter_Type', 'NOC Letter');
    }
}
