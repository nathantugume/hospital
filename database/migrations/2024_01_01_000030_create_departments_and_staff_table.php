<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Departments, wards, staff (unified for all roles), staff HR tables.
 */
return new class extends Migration {
    public function up(): void
    {
        $fullNameExpression = DB::connection()->getDriverName() === 'sqlite'
            ? "first_name || ' ' || last_name"
            : "CONCAT(first_name, ' ', last_name)";

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('code', 20)->nullable()->unique();
            $table->foreignId('head_staff_id')->nullable();
            $table->integer('staff_count')->default(0);
            $table->integer('services_count')->default(0);
            $table->string('icon', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('status', 20)->default('Active');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'status']);
        });

        Schema::create('wards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 20)->nullable();
            $table->timestamps();
            $table->index('department_id');
        });

        Schema::create('staff', function (Blueprint $table) use ($fullNameExpression) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name')->virtualAs($fullNameExpression)->nullable();
            $table->string('initials', 10)->nullable();
            $table->string('email')->unique();
            $table->text('phone')->nullable();
            $table->text('alt_phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('country', 50)->default('Uganda');
            $table->string('role', 100);
            $table->string('position', 100)->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ward_id')->nullable()->constrained()->nullOnDelete();
            $table->string('specialization', 255)->nullable();
            $table->string('secondary_specialization', 255)->nullable();
            $table->string('license_number', 100)->nullable();
            $table->date('license_expiry')->nullable();
            $table->text('qualifications')->nullable();
            $table->integer('experience_years')->default(0);
            $table->text('education')->nullable();
            $table->date('joined_date')->nullable();
            $table->integer('patients_count')->default(0);
            $table->integer('ward_patients_count')->default(0);
            $table->string('avatar')->nullable();
            $table->string('avatar_initials', 10)->nullable();
            $table->string('status', 20)->default('Active');
            $table->text('emergency_contact_name')->nullable();
            $table->text('emergency_contact_phone')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'status']);
            $table->index('role');
            $table->index('department_id');
        });

        // Now add the FK that references staff in departments (after staff exists)
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('head_staff_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('staff_certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->string('cert_name');
            $table->string('issuing_body');
            $table->date('issue_date');
            $table->date('expiry_date')->nullable();
            $table->string('status', 20)->default('valid');
            $table->timestamps();
            $table->index('staff_id');
        });

        Schema::create('staff_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('institution');
            $table->year('year')->nullable();
            $table->timestamps();
        });

        Schema::create('staff_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('status', 20)->default('Present');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->decimal('hours', 5, 2)->default(0);
            $table->timestamps();
            $table->index(['staff_id', 'date']);
        });

        Schema::create('staff_timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->date('week_ending');
            $table->decimal('hours', 5, 2)->default(0);
            $table->decimal('overtime_hours', 5, 2)->default(0);
            $table->string('status', 20)->default('Pending');
            $table->timestamps();
            $table->index(['staff_id', 'status']);
        });

        Schema::create('staff_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->string('type', 30);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('duration', 50)->nullable();
            $table->string('status', 20)->default('Pending');
            $table->text('reason')->nullable();
            $table->foreignId('approved_by')->nullable();
            $table->timestamps();
            $table->index(['staff_id', 'status']);
        });

        Schema::table('staff_leaves', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('staff_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_id')->nullable();
            $table->string('period', 50);
            $table->date('review_date');
            $table->decimal('rating', 3, 1)->nullable();
            $table->string('status', 20)->default('Pending');
            $table->text('comments')->nullable();
            $table->timestamps();
        });

        Schema::table('staff_reviews', function (Blueprint $table) {
            $table->foreign('reviewer_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('patient_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->unsignedTinyInteger('rating');
            $table->string('category', 50);
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->index(['staff_id', 'patient_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_feedback');
        Schema::dropIfExists('staff_reviews');
        Schema::dropIfExists('staff_leaves');
        Schema::dropIfExists('staff_timesheets');
        Schema::dropIfExists('staff_attendance');
        Schema::dropIfExists('staff_education');
        Schema::dropIfExists('staff_certifications');
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['head_staff_id']);
        });
        Schema::dropIfExists('staff');
        Schema::dropIfExists('wards');
        Schema::dropIfExists('departments');
    }
};
