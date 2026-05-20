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
        'payment_type',
        'domicile_number',
        'status',
        'operator_name',
        'priority_type',
    ];

    public function getPriorityLabelAttribute()
    {
        return match ($this->priority_type) {
            1 => 'Normal',
            2 => 'Urgent',
            default => 'Unknown',
        };
    }
}
