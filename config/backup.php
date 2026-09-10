<?php

use Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy;
use Spatie\Backup\BackupDestination\BackupDestination;

return [

    'backup' => [

        /*
         * The name of this application. You can use this name to monitor
         * the backups.
         */
        'name' => env('APP_NAME', 'meditrack-hms'),

        'source' => [

            'files' => [

                /*
                 * The list of directories and files that will be included in the backup.
                 */
                'include' => [
                    base_path(),
                ],

                /*
                 * These directories and files will be excluded from the backup.
                 *
                 * Directories used by the backup process will automatically be excluded.
                 */
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                    base_path('.git'),
                    base_path('storage/app/meditrack-backup'),
                    base_path('storage/logs/laravel.log'),
                ],

                /*
                 * Determines if symlinks should be followed.
                 */
                'follow_links' => false,

                /*
                 * Determines if it should ignore unreadable folders.
                 */
                'ignore_unreadable_directories' => false,

                /*
                 * This path is used to make directories in the resulting zip-file relative
                 * to the configured include path(s).
                 */
                'relative_path' => base_path(),
            ],

            /*
             * The names of the connections to the databases that should be backed up.
             * MySQL, PostgreSQL, SQLite and Mongo databases are supported.
             *
             * The database name is used to look up the database connection in the
             * config/database.php file.
             */
            'databases' => [
                'mysql',
            ],
        ],

        /*
         * The database dump can be compressed to save disk space.
         * Supported: 'none', 'gzip', 'lz4'
         */
        'database_dump_compressor' => 'gzip',

        /*
         * If specified, the database dump file will use this extension.
         */
        'database_dump_file_extension' => '',

        'destination' => [

            /*
             * The filename prefix used for the backup zip file.
             */
            'filename_prefix' => 'meditrack_backup_',

            /*
             * The disk names on which the backups will be stored.
             */
            'disks' => [
                'local',
                // 's3',  // Enable for cloud backup to AWS S3
            ],
        ],

        /*
         * The directory where the temporary zip files will be stored.
         */
        'temporary_directory' => storage_path('app/meditrack-backup/temp'),
    ],

    /*
     * You can get notified when specific events occur. Out of the box you can use 'mail' and 'slack'.
     * For Slack you need to install the maknz/slack package.
     *
     * You can also use your own notification classes, just make sure the class is registered.
     */
    'notifications' => [

        'notifications' => [
            \Spatie\Backup\Notifications\Notifications\BackupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailedNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessfulNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFoundNotification::class => ['mail'],
            \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessfulNotification::class => ['mail'],
        ],

        /*
         * Here you can specify the notifiable to send notifications to.
         */
        'notifiable' => \App\Models\User::class,

        /*
         * The email address to send notifications to.
         */
        'mail' => [
            'to' => env('BACKUP_NOTIFICATION_EMAIL', 'admin@meditrack-healthcare.com'),
        ],

        /*
         * The Slack webhook URL to send notifications to.
         */
        'slack' => [
            'webhook_url' => env('BACKUP_SLACK_WEBHOOK_URL', ''),
        ],
    ],

    /*
     * Here you can configure which strategies should be used for cleanup.
     */
    'cleanup' => [
        /*
         * The class that contains the cleanup logic.
         */
        'strategy' => DefaultStrategy::class,

        'default_strategy' => [
            /*
             * The number of days for which backups must be kept.
             */
            'keep_all_backups_for_days' => 7,

            /*
             * After the "keep_all_backups_for_days" period is over, the most recent backup
             * of each day is kept.
             */
            'keep_daily_backups_for_days' => 16,

            /*
             * After the "keep_daily_backups_for_days" period is over, the most recent backup
             * of each week is kept.
             */
            'keep_weekly_backups_for_weeks' => 8,

            /*
             * After the "keep_weekly_backups_for_weeks" period is over, the most recent backup
             * of each month is kept.
             */
            'keep_monthly_backups_for_months' => 4,

            /*
             * After the "keep_monthly_backups_for_months" period is over, the most recent backup
             * of each year is kept.
             */
            'keep_yearly_backups_for_years' => 5,

            /*
             * After cleaning up the backups of the respective periods, delete all backups
             * that are older than this.
             */
            'delete_oldest_backups_when_using_more_megabytes_than' => 5000,
        ],
    ],

    /*
     * Monitor the health of the backups.
     */
    'monitor_backups' => [
        [
            'name' => env('APP_NAME', 'meditrack-hms'),
            'disks' => ['local'],
            'health_checks' => [
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumAgeInDays::class => 1,
                \Spatie\Backup\Tasks\Monitor\HealthChecks\MaximumStorageInMegabytes::class => 5000,
            ],
        ],
    ],

    'password' => env('BACKUP_ARCHIVE_PASSWORD'),

    'enable_backup_wait' => true,

    'timeout_in_seconds' => 60 * 5,

    /*
     * Additional output options for the gzip command.
     */
    'gzip_command_options' => '-rsync',

    /*
     * Database dump command options.
     */
    'database_dump_command_timeout' => 60 * 5,

    'database_dump_command_pgsql' => 'pg_dump',

    'database_dump_command_mysql' => 'mysqldump',

    'database_dump_command_sqlite' => 'sqlite3',

    'database_dump_command_mongodb' => 'mongodump',
];
