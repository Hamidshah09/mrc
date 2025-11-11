<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdpHistory extends Model
{
    protected $table = 'idp_history';

    protected $fillable = [
        'nitb_id',
        'cnic',
        'first_name',
        'last_name',
        'father_name' ,
        'date_of_birth',
        'place_of_birth',
        'contact',
        'app_issue_date',
        'app_expiry_date',
        'user_id',
        'amount',
        'driving_license_no',
        'driving_license_issue',
        'driving_license_expiry',
        'driving_years',
        'application_type',
        'center_id',
        'status',
    ];
}
