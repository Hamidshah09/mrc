<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuretyRegister extends Model
{
    protected $table = 'suretyregister';
    protected $fillable = [
        'register_id',
        'guarantor_name',
        'mobile_no',
        'receipt_no',
        'receiving_date',
        'police_station_id',
        'section_of_law',
        'accused_name',
        'amount',
        'surety_type_id',
        'surety_status_id',
        'user_id',
        'document_id'
    ];

    public function suretyType()
    {
        return $this->belongsTo(SuretyType::class, 'surety_type_id');
    }

    public function suretyStatus()
    {
        return $this->belongsTo(SuretyStatus::class, 'surety_status_id');
    }

    public function policeStation()
    {
        return $this->belongsTo(PoliceStation::class, 'police_station_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
