<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationLetter extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'verification_letters';
    protected $fillable = [
        'Letter_ID',
        'Letter_Date',
        'Letter_No',
        'Letter_Sent_by',
        'Designation',
        'Sender_Address',
        'Letter_Issuance_Date',
        'Remarks',
    ];
    public function applicants(){
        return $this->hasMany(VerificationLetterApplicant::class, 'Letter_ID', 'Letter_ID');
    }
}
