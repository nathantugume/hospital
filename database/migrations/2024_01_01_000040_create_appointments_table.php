<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Appointments, appointment_requests.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('time_label', 20)->nullable();
            $table->string('duration', 20)->default('30 min');
            $table->string('type', 50)->default('Check-up');
            $table->string('status', 20)->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'date', 'status']);
            $table->index('patient_id');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('appointment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable();
            $table->date('requested_date');
            $table->string('requested_time', 20)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('status', 20)->default('Pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'requested_date']);
        });

        Schema::table('appointment_requests', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_requests');
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
        });
        Schema::dropIfExists('appointments');
    }
};
