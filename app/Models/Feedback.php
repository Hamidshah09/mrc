<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    protected $fillable = [
        'service_type_id',
        'document_no',
        'citizen_name',
        'rating',
        'suggestions',
    ];

    public function service()
    {
        return $this->belongsTo(\App\Models\Services::class, 'service_type_id');
    }
}
