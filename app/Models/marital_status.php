<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class marital_status extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'marital_statuses';
}
