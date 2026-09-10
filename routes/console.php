<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ============================================================
// SCHEDULED TASKS
// ============================================================

// --- Backup (nightly at 2 AM) ---
// Full database + files backup to local disk (and S3 if configured).
// Old backups are cleaned up automatically per config/backup.php retention policy.
Schedule::command('backup:clean')->daily()->at('01:00')->description('Clean old backups');
Schedule::command('backup:run')->daily()->at('02:00')->description('Run full nightly backup');
Schedule::command('backup:monitor')->daily()->at('03:00')->description('Monitor backup health');

// --- System maintenance ---
Schedule::command('horizon:snapshot')->everyFiveMinutes()->description('Horizon metrics snapshot');
Schedule::command('meditrack:clean-expired-tokens')->daily()->at('03:30')->description('Clean expired Sanctum tokens');
Schedule::command('meditrack:expire-lab-results')->daily()->at('04:00')->description('Mark expired lab results');

// --- Business logic ---
Schedule::command('meditrack:send-appointment-reminders')->everyFifteenMinutes()->description('Send SMS reminders for upcoming appointments');
Schedule::command('meditrack:check-low-stock')->hourly()->description('Check inventory for low-stock items and alert pharmacy manager');
Schedule::command('meditrack:sync-ambulance-gps')->everyMinute()->description('Sync ambulance GPS positions from OnTrack API');

// --- GDPR / Data retention ---
Schedule::command('meditrack:anonymize-expired-records')->daily()->at('04:30')->description('Anonymize patient records past 7-year retention period');
Schedule::command('meditrack:delete-old-audit-logs')->monthly()->description('Delete audit logs older than 7 years');

// --- Health check ---
Schedule::command('meditrack:health-check')->everyFiveMinutes()->description('Run system health check and alert if degraded');

