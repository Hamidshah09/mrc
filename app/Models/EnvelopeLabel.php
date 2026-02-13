<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvelopeLabel extends Model
{
    use HasFactory;

    protected $table = 'postal_services'; // Use the same table as PostalService

    // Only allow mass assignment for the fields we need
    protected $fillable = [
        'receiver_name',
        'receiver_address',
        'phone_number',
        'created_at',
    ];

    // No timestamps needed for this model
    public $timestamps = false;
}
