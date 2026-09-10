<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The Add/Edit Patient form's Insurance tab doesn't mark Policy Number
 * as required (only Provider triggers creating the insurance record),
 * so registering a patient whose policy number isn't in hand yet was
 * throwing a NOT NULL constraint violation.
 */
return new class extends Migration {
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            $this->rebuildForSqlite();

            return;
        }

        DB::statement('ALTER TABLE patient_insurances MODIFY policy_number VARCHAR(255) NULL');
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            // Not reversible without risking data loss if a NULL policy_number
            // was saved in the meantime; leave the column nullable.
            return;
        }

        DB::statement('ALTER TABLE patient_insurances MODIFY policy_number VARCHAR(255) NOT NULL');
    }

    private function rebuildForSqlite(): void
    {
        Schema::create('patient_insurances_new', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->string('provider');
            $table->string('policy_number')->nullable();
            $table->string('group_number')->nullable();
            $table->string('policy_holder')->nullable();
            $table->string('relationship', 20)->default('Self');
            $table->string('provider_phone', 30)->nullable();
            $table->string('verification_status', 20)->default('Pending');
            $table->timestamps();
            $table->index(['patient_id', 'is_primary']);
        });

        DB::statement('INSERT INTO patient_insurances_new SELECT * FROM patient_insurances');
        Schema::drop('patient_insurances');
        Schema::rename('patient_insurances_new', 'patient_insurances');
    }
};
