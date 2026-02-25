<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PostalService extends Model
{
    protected $fillable = [
        'article_number',
        'receiver_name',
        'receiver_address',
        'receiver_city_id',
        'phone_number',
        'weight',
        'rate',
        'status_id',
        'service_id',
        'user_id',
    ];
    protected $table = 'postalservice';
    public function status()
    {
        return $this->belongsTo(PostalStatuses::class);
    }
    
    public function history()
    {
        return $this->hasMany(PostalHistory::class, 'postalservice_id');
    }
    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'receiver_city_id');
    }

    public function gpoDelayBadge(): array
    {
        // Status ID for "Received by GPO"
        $RECEIVED_GPO_STATUS_ID = 6;

        // If not currently at GPO, no delay badge
        if ($this->status_id !== $RECEIVED_GPO_STATUS_ID) {
            return [
                'text'  => '—',
                'class' => 'bg-gray-100 text-gray-600',
            ];
        }

        // Days since last status update
        $days = Carbon::parse($this->updated_at)->diffInDays(now());

        return match (true) {
            $days < 3 => [
                'text'  => 'Normal',
                'class' => 'bg-green-100 text-green-800',
            ],
            $days < 7 => [
                'text'  => 'Delayed',
                'class' => 'bg-yellow-100 text-yellow-800',
            ],
            $days < 10 => [
                'text'  => 'Alarming',
                'class' => 'bg-red-100 text-red-800',
            ],
            default => [
                'text'  => 'Critical',
                'class' => 'bg-red-800 text-white',
            ],
        };
    }
    public function scopeDelayStatus($query, ?string $delay)
    {
        if (!$delay) {
            return $query;
        }

        // Only records received by GPO
        $RECEIVED_GPO_STATUS_ID = 6;
        $query->where('status_id', $RECEIVED_GPO_STATUS_ID);

        return match ($delay) {
            'normal' =>
                $query->whereDate('updated_at', '>=', now()->subDays(3)),

            'delayed' =>
                $query->whereBetween('updated_at', [
                    now()->subDays(7),
                    now()->subDays(3),
                ]),

            'alarming' =>
                $query->whereBetween('updated_at', [
                    now()->subDays(10),
                    now()->subDays(7),
                ]),

            'critical' =>
                $query->whereDate('updated_at', '<', now()->subDays(10)),

            default => $query,
        };
    }
    
}
