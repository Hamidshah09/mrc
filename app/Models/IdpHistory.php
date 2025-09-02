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
        'row_type'
    ];
}
