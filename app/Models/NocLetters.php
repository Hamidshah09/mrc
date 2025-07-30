<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NocLetters extends Model
{
    protected $guarded = [];
    protected $table= 'nocletters';
    public function nocapplicants(){
        return $this->hasMany(NocApplicants::class,  'letter_id',  'id');
    }
}
