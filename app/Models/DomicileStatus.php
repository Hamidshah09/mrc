<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomicileStatus extends Model
{
    protected $table = 'domicile_status';
    protected $filable = ['id', 'first_name', 'cnic', 'receipt_no', 'remarks'];
    
}
