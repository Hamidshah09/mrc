<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Complaint;
use App\Models\SubDivision;
use App\Models\PoliceStation;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,  HasApiTokens,Notifiable;
    protected $connection = 'mysql';
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
        'sub_division_id',
        'policestation_id',
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

    public function isAdmin()
    {
        return $this->role->role && $this->role->role === 'admin';
    }

    public function suretyregister(){
        return $this->hasMany(SuretyRegister::class, 'user_id', 'id');
    }

        /*
    |--------------------------------------------------------------------------
    | Area Relationships
    |--------------------------------------------------------------------------
    */

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class);
    }

    public function policeStation()
    {
        return $this->belongsTo(PoliceStation::class, 'policestation_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Complaint Relationships
    |--------------------------------------------------------------------------
    */

    public function submittedComplaints()
    {
        return $this->hasMany(Complaint::class, 'operator_id');
    }

    public function assignedComplaints()
    {
        return $this->hasMany(Complaint::class, 'ac_id');
    }

    public function magistrateComplaints()
    {
        return $this->hasMany(Complaint::class, 'magistrate_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)
            ->where('is_read', false);
    }
}
