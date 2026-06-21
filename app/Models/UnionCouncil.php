<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnionCouncil extends Model
{
    protected $fillable = [
        'name',
    ];

    public function userAssignments()
    {
        return $this->morphMany(UserAssignment::class, 'assignable');
    }
}
