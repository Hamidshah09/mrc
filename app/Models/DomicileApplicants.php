<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomicileApplicants extends Model
{
    protected $connection = 'remote_mysql';
    protected $primaryKey = 'id';
    protected $table = 'domicile';
    protected $fillable = [
        'status',
        'cnic',
        'first_name',
        'father_name',
        'spouse_name',
        'date_of_birth',
        'gender_id',
        'place_of_birth',
        'marital_status_id',
        'religion',
        'qualification_id',
        'occupation_id',
        'contact',
        'arrival_date',
        'passcode',
        'present_province_id',
        'present_district_id',
        'present_tehsil_id',
        'present_address',
        'permanent_province_id',
        'permanent_district_id',
        'permanent_tehsil_id',
        'permanent_address',
        'application_type_id',
        'service_type_id',
        'payment_type_id',
        'request_type_id',
        'user_id',
        'remarks',
        'priority_type',
        'purpose',
        'approver_id',
        'receipt_no',
        'picture_path',
        'noc_letter_id',
        'other_district_status',
        'nitb_status',
        'noc_other_district_letter',
        'noc_ict_letter',
        'cancellation_letter',
        'blacklist_status',
    ];
    // protected $casts = ['date_of_arrival' => 'date', 'date_of_birth'=>'date'];
    
    public function children(){
        return $this->hasMany(children::class, 'applicant_id', 'id');
    }
    public function marital_statuses()
    {
        return $this->belongsTo(marital_status::class, 'marital_status_id', 'id');
    }

    public function occupations()
    {
        return $this->belongsTo(occupation::class, 'occupation_id', 'id');
    }


}
