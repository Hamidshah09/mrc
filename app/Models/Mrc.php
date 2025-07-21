<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mrc extends Model
{
    protected $fillable = [
        'groom_name',
        'bride_name',
        'groom_father_name',
        'bride_father_name',
        'groom_passport',
        'bride_passport',
        'groom_cnic',
        'bride_cnic',
        'marriage_date',
        'registration_date',
        'registrar_id',
        'verifier_id',
        'verification_date',
        'remarks',
        'register_no',
        'status'
    ];
    protected $table = 'mrc';
    public function registrar()
    {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    /**
     * Relationship with the User model (Verifier).
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }
}
