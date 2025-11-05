<?php
// app/Models/ArmsLicense.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Approver;

class ArmsLicense extends Model
{
    
    protected $fillable = [
        'id','name', 'cnic', 'guardian_name', 'mobile',
        'weapon_number', 'license_number', 'caliber', 
        'weapon_type', 'issue_date', 'expire_date', 'address',
        'approver_id', 'character_certificate', 'address_on_cnic', 'affidavit', 'updated_by'
    ];


    // This mimics a relationship (virtual accessor)
    public function getApproverIdAttribute($value)
    {
        return $value ? Approver::from($value) : null;
    }

    public function setApproverIdAttribute($value)
    {
        $this->attributes['approver_id'] = $value instanceof Approver
            ? $value->value
            : ($value ?: null);
    }

    public function getApproverAttribute()
    {
        return $this->approver_id?->label() ?? 'N/A';
    }

    public function user(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
