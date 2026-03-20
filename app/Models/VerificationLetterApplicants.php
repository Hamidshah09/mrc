<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationLetterApplicants extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'verification_applicants';
    protected $fillable = [
        'Letter_ID',
        'App_ID',
        'Applicant_Name',
        'Relation',
        'Applicant_FName',
        'address',
        'CNIC',
        'Domicile_No',
        'Domicile_Date'
    ];

    
}
