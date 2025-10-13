<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;

class NocLetters extends Model
{
    use Userstamps;
    protected $guarded = [];
    protected $table= 'nocletters';
    public function nocapplicants(){
        return $this->hasMany(NocApplicants::class,  'letter_id',  'id');
    }
}
