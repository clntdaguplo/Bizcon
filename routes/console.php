<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule consultation reminders to run every hour
Schedule::command('consultations:send-reminders')
    ->hourly()
    ->withoutOverlapping();
