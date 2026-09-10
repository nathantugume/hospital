<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Birth/death records, services + availability + providers,
 * payroll_entries + payslips, physiotherapy, vaccinations.
 */
return new class extends Migration {
    public function up(): void
    {
        // --- Birth records ---
        Schema::create('birth_records', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('child_name');
            $table->date('date_of_birth');
            $table->time('time_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('parents', 255)->nullable();
            $table->string('mother_name', 255)->nullable();
            $table->string('father_name', 255)->nullable();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('doctor_id')->nullable();
            $table->string('doctor_name', 255)->nullable();
            $table->string('place_of_birth', 255)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('status', 20)->default('Verified');
            $table->timestamps();
            $table->index(['date_of_birth', 'status']);
        });

        Schema::table('birth_records', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('staff')->nullOnDelete();
        });

        // --- Death records ---
        Schema::create('death_records', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->unsignedInteger('age');
            $table->date('date_of_death');
            $table->time('time_of_death')->nullable();
            $table->string('cause', 255);
            $table->foreignId('doctor_id')->nullable();
            $table->string('doctor_name', 255)->nullable();
            $table->string('location', 100)->nullable();
            $table->string('status', 20)->default('Verified');
            $table->timestamps();
            $table->index(['date_of_death', 'status']);
        });

        Schema::table('death_records', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('staff')->nullOnDelete();
        });

        // --- Services ---
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('department_name', 100)->nullable();
            $table->string('type', 30)->default('Preventive');
            $table->string('duration', 50)->default('30 min');
            $table->decimal('price', 14, 2)->default(0);
            $table->string('currency', 3)->default('UGX');
            $table->unsignedInteger('popularity')->default(0);
            $table->string('status', 20)->default('Active');
            $table->timestamps();
            $table->index(['department_id', 'status']);
        });

        // Add FK on invoice_services now that services exists
        Schema::table('invoice_services', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('services')->nullOnDelete();
        });

        Schema::create('service_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('day_of_week', 10);
            $table->text('slots');
            $table->timestamps();
            $table->index('service_id');
        });

        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->boolean('assigned')->default(false);
            $table->timestamps();
            $table->index(['service_id', 'assigned']);
        });

        // --- Payroll ---
        Schema::create('payroll_entries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->string('employee_name', 255);
            $table->string('email')->nullable();
            $table->date('joining_date');
            $table->string('role', 100);
            $table->decimal('salary', 14, 2);
            $table->string('currency', 3)->default('UGX');
            $table->string('status', 20)->default('Active');
            $table->string('payment_method', 30)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('bank_account', 100)->nullable();
            $table->string('mobile_money_provider', 30)->nullable();
            $table->text('mobile_money_number')->nullable();
            $table->timestamps();
            $table->index(['staff_id', 'status']);
        });

        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('payroll_entry_id')->constrained()->cascadeOnDelete();
            $table->string('period', 30);
            $table->decimal('gross_salary', 14, 2);
            $table->decimal('deductions', 14, 2)->default(0);
            $table->decimal('net_salary', 14, 2);
            $table->string('currency', 3)->default('UGX');
            $table->string('status', 20)->default('Draft');
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->index('payroll_entry_id');
        });

        // --- Physiotherapy ---
        Schema::create('physiotherapy_sessions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('therapist_id')->nullable();
            $table->string('type', 50)->default('Follow-up');
            $table->string('room', 100)->nullable();
            $table->string('duration', 20)->default('45 min');
            $table->string('condition', 255)->nullable();
            $table->string('status', 20)->default('Scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'date']);
        });

        Schema::table('physiotherapy_sessions', function (Blueprint $table) {
            $table->foreign('therapist_id')->references('id')->on('staff')->nullOnDelete();
        });

        // --- Vaccinations ---
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('vaccine_name', 255);
            $table->string('dose', 50)->nullable();
            $table->date('date');
            $table->foreignId('administered_by')->nullable();
            $table->string('status', 20)->default('Completed');
            $table->date('next_dose_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'date']);
        });

        Schema::table('vaccinations', function (Blueprint $table) {
            $table->foreign('administered_by')->references('id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
        Schema::dropIfExists('physiotherapy_sessions');
        Schema::dropIfExists('payslips');
        Schema::dropIfExists('payroll_entries');
        Schema::dropIfExists('service_providers');
        Schema::dropIfExists('service_availability');
        Schema::table('invoice_services', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
        });
        Schema::dropIfExists('services');
        Schema::table('death_records', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
        });
        Schema::dropIfExists('death_records');
        Schema::table('birth_records', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
        });
        Schema::dropIfExists('birth_records');
    }
};
