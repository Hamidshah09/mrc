<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispatchDiary extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'dispatch_dairy';
    protected $primaryKey = 'Dispatch_ID';
    public $timestamps = false;
    protected $fillable = [
                    'Dispatch_ID',
                    'Dispatch_No',
                    'Letter_Type',
                    'Letter_ID'
                    ];
    protected $casts = [
        'timestamp' => 'datetime',
    ];
    
}
