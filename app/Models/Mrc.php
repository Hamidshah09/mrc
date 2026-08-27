<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;

class Mrc extends Model
{
    use Userstamps;
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
        'user_id',
        'status',
        'verifier_id',
        'verification_date',
        'remarks',
        'register_no',
        'image',
        'created_by',
        'updated_by',
        'deleted_by',
        'registrar_name',
        'union_council_id',
    ];
    protected $table = 'mrc';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function unionCouncil()
    {
        return $this->belongsTo(UnionCouncil::class, 'union_council_id');
    }

    /**
     * Relationship with the User model (Verifier).
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }
}
