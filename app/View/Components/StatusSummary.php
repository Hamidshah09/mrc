<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusSummary extends Component
{
    public $record;

    public function __construct($record)
    {
        $this->record = $record;
    }

    public function getStatuses()
    {
        return [
            [
                'label' => 'OTHER DISTRICT',
                'value' => $this->record->other_district_status,
                'type'  => 'boolean',
            ],
            [
                'label' => 'NITB',
                'value' => $this->record->nitb_status,
                'type'  => 'boolean',
            ],
            [
                'label' => 'NOC OD',
                'value' => $this->record->noc_other_district_letter,
                'type'  => 'boolean',
            ],
            [
                'label' => 'NOC ICT',
                'value' => $this->record->noc_ict_letter,
                'type'  => 'boolean',
            ],
            [
                'label' => 'CANCEL',
                'value' => $this->record->cancellation_letter,
                'type'  => 'boolean',
            ],
            [
                'label' => 'BLACK LIST',
                'value' => $this->record->blacklist_status,
                'type'  => 'boolean',
            ],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.status-summary', [
            'statuses' => $this->getStatuses()
        ]);
    }
}