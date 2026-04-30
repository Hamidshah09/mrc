<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseRegister extends Model
{
    protected $table = 'expense_register';

    protected $fillable = [
        'account_head',
        'amount',
        'month',
        'year',
    ];
}
