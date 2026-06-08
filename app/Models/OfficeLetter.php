<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeLetter extends Model
{
    protected $connection = 'remote_mysql';

    protected $table = 'office_letters';
    public $fillable = [
        'letter_date',
        'letter_to',
        'subject',
    ];

    public function dispatchDiary()
    {
        return $this->hasOne(DispatchDiary::class, 'Letter_ID', 'id')
                    ->where('Letter_Type', 'Office Letter');
    }
}
