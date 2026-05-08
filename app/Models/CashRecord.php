<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashRecord extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'cashrecords';
    protected $fillable = [
        'date',
        'cnic',
        'name',
        'mobile',
        'service_type',
        'request_type',
        'domicile_number',
        'status',
        'operator_name',
    ];
}
