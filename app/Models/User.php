<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,  HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cnic',
        'name',
        'father_name',
        'address',
        'dob',
        'email',
        'status',
        'role_id',
        'password',
        'mobile',
        'profile_image',
        'license_number',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registeredMrcs()
    {
        return $this->hasMany(Mrc::class, 'registrar_id');
    }

    /**
     * Get the MRCs where the user is the verifier.
     */
    public function verifiedMrcs()
    {
        return $this->hasMany(Mrc::class, 'verifier_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function online_application(){
        return $this->hasMany(OnlineApplication::class, 'created_by', 'id');
    }
}
