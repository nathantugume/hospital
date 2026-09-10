<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Blood bank: blood_donors, blood_donations, blood_units, blood_issues.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('blood_donors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('blood_type', 5);
            $table->text('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('last_donation')->nullable();
            $table->string('status', 20)->default('Eligible');
            $table->unsignedInteger('total_donations')->default(0);
            $table->date('next_eligible')->nullable();
            $table->string('donor_tier', 30)->default('New');
            $table->timestamps();
            $table->index(['blood_type', 'status']);
        });

        Schema::create('blood_units', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('blood_type', 5);
            $table->unsignedInteger('units')->default(1);
            $table->date('collection_date');
            $table->date('expiry_date');
            $table->string('status', 20)->default('Available');
            $table->string('location', 100)->nullable();
            $table->foreignId('donor_id')->nullable()->constrained('blood_donors')->nullOnDelete();
            $table->string('donor_name', 255)->nullable();
            $table->timestamps();
            $table->index(['blood_type', 'status', 'expiry_date']);
        });

        Schema::create('blood_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained('blood_donors')->cascadeOnDelete();
            $table->foreignId('blood_unit_id')->nullable()->constrained('blood_units')->nullOnDelete();
            $table->date('date');
            $table->string('type', 30)->default('Whole Blood');
            $table->string('volume', 50)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('status', 20)->default('Completed');
            $table->timestamps();
            $table->index('donor_id');
        });

        Schema::create('blood_issues', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('recipient', 255);
            $table->string('recipient_type', 20)->default('patient');
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->string('blood_type', 5);
            $table->unsignedInteger('units')->default(1);
            $table->date('date');
            $table->foreignId('doctor_id')->nullable();
            $table->string('doctor_name', 255)->nullable();
            $table->string('purpose', 255)->nullable();
            $table->string('status', 20)->default('Pending');
            $table->boolean('emergency')->default(false);
            $table->string('department', 100)->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'status']);
        });

        Schema::table('blood_issues', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_issues');
        Schema::dropIfExists('blood_donations');
        Schema::dropIfExists('blood_units');
        Schema::dropIfExists('blood_donors');
    }
};
