<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomicileApprover extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'approvers';

    protected $fillable = [
        'name',
        'designation',
    ];
}
