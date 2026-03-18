<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlackListDomicileApplications extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'black_list';
    protected $primaryKey = 'black_list_id';
    public $timestamps = false;

    protected $fillable = [
        'cnic',
        'status',
        'reason',
        'clearance_reason',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
