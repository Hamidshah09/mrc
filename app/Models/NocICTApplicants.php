<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NocICTApplicants extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'noc_ict_applicants';
    public $timestamps = false;
    protected $primaryKey = 'App_ID';
    protected $fillable = [
        'App_ID',
        'Letter_ID',
        'Applicant_Name',
        'CNIC',
        'Relation',
        'Applicant_FName',
    ];
    public function nocletter()
    {
        return $this->belongsTo(NocICTLetters::class, 'Letter_ID', 'Letter_ID');
    }
}
