<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('railway:sync-trains', function () {
    $this->info('Syncing train data from external source...');
    // Command to sync train data
})->purpose('Sync train data from external API');

Artisan::command('railway:send-reminders', function () {
    $this->info('Sending journey reminders to passengers...');
    // Command to send SMS reminders
})->purpose('Send journey reminders to passengers');
