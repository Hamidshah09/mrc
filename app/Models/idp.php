<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class idp extends Model
{
    // app/Models/Idp.php

    protected $fillable = [
        'idp_no',
        'first_name',
        'last_name',
        'father_name',
        'gender_id',
        'date_of_birth',
        'cnic',
        'place_of_birth',
        'qualification_id',
        'occupation_id',
        'temporary_address_province_id',
        'temporary_address_district_id',
        'temporary_address_tehsil_id',
        'temporary_address',
        'contact',
        'driving_license_number',
        'driving_license_issue_date',
        'driving_license_expiry_date',
        'driving_license_vehicle_type_id',
        'driving_license_issuing_authority',
        'passport_number',
        'passport_issue_date',
        'passport_expiry_date',
        'passport_type_id',
        'applicant_type_id',
        'request_type_id',
        'service_type_id',
        'payment_type_id',
        'application_type',
        'app_issue_date',
        'driving_years',
        'app_expiry_date',
        'amount',
        'remarks',
        'photo',
    ];
}
