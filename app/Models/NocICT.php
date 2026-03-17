<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NocICT extends Model
{
    protected $connection = 'remote_mysql';
    protected $table = 'noc_ict_letters';
    public $timestamps = false;
    protected $primaryKey = 'Letter_ID';
    protected $fillable = [
        'letter_date',
        'letter_sent_to',
    ];

    public function applicants()
    {
        return $this->hasMany(NocICTApplicants::class, 'Letter_ID', 'Letter_ID');
    }

    public function dispatchDiary()
    {
        return $this->hasOne(DispatchDiary::class, 'Letter_ID')
                    ->where('Letter_Type', 'NOC ICT Letter');
    }
}
