<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;

class OnlineApplication extends Model
{
    use Userstamps;
    protected $fillable=['application_type_id',
            'application_status_id',
            'role_id'              ,
            'documents'            , ];
    public function application_status(){
        return $this->belongsTo(ApplicationStatus::class,'application_status_id', 'id');
    }
    public function application_type(){
        return $this->belongsTo(ApplicationType::class,'application_type_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
