<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class occupation extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'occupations';
}
