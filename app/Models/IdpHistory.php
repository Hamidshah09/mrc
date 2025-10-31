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
        'father_name',
        'user_id',
        'amount',
        'driving_license_no',
        'driving_license_issue',
        'driving_license_expiry',
        'status',
    ];
}
