<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointment_requests', function (Blueprint $table): void {
            $table->foreignId('company_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->index(['company_id', 'status', 'requested_date']);
        });

        DB::statement('UPDATE appointment_requests SET company_id = (SELECT company_id FROM patients WHERE patients.id = appointment_requests.patient_id) WHERE company_id IS NULL');
    }

    public function down(): void
    {
        Schema::table('appointment_requests', function (Blueprint $table): void {
            $table->dropForeign(['company_id']);
            $table->dropIndex(['company_id', 'status', 'requested_date']);
            $table->dropColumn('company_id');
        });
    }
};
