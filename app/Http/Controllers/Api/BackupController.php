<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    /**
     * GET /api/v1/admin/backup/status
     * Returns backup status information.
     */
    public function status(): JsonResponse
    {
        $backupDisk = Storage::disk('local');
        $backupPath = 'meditrack-backup';
        $backups = [];

        if ($backupDisk->exists($backupPath)) {
            $files = $backupDisk->allFiles($backupPath);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'zip') {
                    $backups[] = [
                        'filename' => basename($file),
                        'size' => $this->formatSize($backupDisk->size($file)),
                        'created_at' => date('Y-m-d H:i:s', $backupDisk->lastModified($file)),
                    ];
                }
            }
        }

        $lastBackup = !empty($backups) ? $backups[0]['created_at'] : null;
        $totalSize = array_sum(array_map(fn($b) => $backupDisk->size($backupPath . '/' . $b['filename']), $backups));

        return response()->json([
            'success' => true,
            'data' => [
                'last_backup' => $lastBackup,
                'size' => $this->formatSize($totalSize),
                'status' => $lastBackup ? 'healthy' : 'no backups yet',
                'total_backups' => count($backups),
                'backups' => array_slice($backups, 0, 10),
                'next_scheduled' => 'Tonight at 2:00 AM',
                'retention_policy' => '7 days all → 16 days daily → 8 weeks weekly → 4 months monthly → 5 years yearly',
            ],
        ]);
    }

    /**
     * POST /api/v1/admin/backup/run
     * Triggers a manual backup.
     */
    public function run(): JsonResponse
    {
        try {
            Artisan::call('backup:run');
            $output = Artisan::output();

            return response()->json([
                'success' => true,
                'message' => 'Backup completed successfully.',
                'data' => [
                    'output' => $output,
                    'completed_at' => now()->toIso8601String(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/v1/admin/backup/clean
     * Cleans old backups per retention policy.
     */
    public function clean(): JsonResponse
    {
        try {
            Artisan::call('backup:clean');
            return response()->json([
                'success' => true,
                'message' => 'Backup cleanup completed.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cleanup failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function formatSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
