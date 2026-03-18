<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomicileCancellation extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'cancellation';
    protected $primaryKey = 'Letter_ID';
    public $timestamps = false;

    protected $fillable = [
        'Letter_Date', 
        'CNIC',
        'Applicant_Name',
        'Relation',
        'Applicant_FName',
        'Address',
        'Domicile_No',
        'Domicile_Date',
        'Remarks'
    ];

    function dispatchDiary(){
        return $this->hasOne(DispatchDiary::class, 'Letter_ID', 'Letter_ID')->where('Letter_Type', 'Domicile Cancellation');
    }
}
