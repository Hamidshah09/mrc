<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('counters:update')->everyFifteenMinutes();
Schedule::command('import:domicile-status')
    ->hourly()
    ->appendOutputTo(storage_path('logs/domicile_import.log'));
