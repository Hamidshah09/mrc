<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlackListHistory extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'black_list_history';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'black_list_id',
        'remarks',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
}
