<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Patients — core HMS entity. PII columns are encrypted via model casts.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('full_name')->virtualAs('CONCAT(first_name, " ", last_name)')->nullable();
            $table->date('date_of_birth');
            $table->integer('age')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('marital_status', 20)->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->string('height', 20)->nullable();
            $table->string('weight', 20)->nullable();
            // PII: encrypted at application layer
            $table->text('phone')->nullable();
            $table->text('alternate_phone')->nullable();
            $table->text('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('country', 50)->default('Uganda');
            $table->string('postal_code', 20)->nullable();
            $table->string('preferred_contact', 20)->default('phone');
            $table->text('national_id')->nullable();
            $table->string('national_id_type', 30)->nullable()->comment('NIRA, NIIMS, NIDA, etc.');
            $table->string('nationality', 50)->default('Ugandan');
            $table->text('condition')->nullable();
            $table->text('allergies')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('chronic_conditions')->nullable();
            $table->text('past_surgeries')->nullable();
            $table->text('family_history')->nullable();
            $table->text('medical_history')->nullable();
            $table->string('hiv_status', 20)->nullable();
            $table->string('smoking_status', 20)->nullable();
            $table->string('alcohol_consumption', 20)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relationship', 50)->nullable();
            $table->text('emergency_contact_phone')->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_initials', 10)->nullable();
            $table->date('last_visit')->nullable();
            $table->string('status', 20)->default('Active');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'status']);
            $table->index('date_of_birth');
            $table->index('city');
        });

        Schema::create('patient_emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('relationship', 50);
            $table->text('phone');
            $table->string('email')->nullable();
            $table->timestamps();
            $table->index('patient_id');
        });

        Schema::create('patient_insurances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->string('provider');
            $table->string('policy_number');
            $table->string('group_number')->nullable();
            $table->string('policy_holder')->nullable();
            $table->string('relationship', 20)->default('Self');
            $table->string('provider_phone', 30)->nullable();
            $table->string('verification_status', 20)->default('Pending');
            $table->timestamps();
            $table->index(['patient_id', 'is_primary']);
        });

        Schema::create('patient_consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('consent_type', 30)->comment('data_protection, treatment, financial');
            $table->string('consent_status', 20)->default('pending');
            $table->timestamp('signed_at')->nullable();
            $table->text('signature_data')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'consent_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_consents');
        Schema::dropIfExists('patient_insurances');
        Schema::dropIfExists('patient_emergency_contacts');
        Schema::dropIfExists('patients');
    }
};
