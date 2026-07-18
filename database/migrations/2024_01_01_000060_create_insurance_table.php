<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Insurance claims + claim_services + insurance_providers + insurance_communications.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('insurance_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 20)->nullable();
            $table->string('country', 50)->default('Uganda');
            $table->string('api_url')->nullable();
            $table->text('api_key')->nullable();
            $table->string('api_provider_key', 30)->nullable()->comment('key into config("services.insurance.providers")');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('status', 20)->default('Active');
            $table->timestamps();
            $table->index(['country', 'status']);
        });

        Schema::create('insurance_claims', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('insurance_provider_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provider');
            $table->string('policy_number');
            $table->string('group_number')->nullable();
            $table->string('relationship', 20)->default('Self');
            $table->date('submitted_date')->nullable();
            $table->decimal('amount', 14, 2);
            $table->decimal('approved_amount', 14, 2)->nullable();
            $table->string('currency', 3)->default('UGX');
            $table->string('status', 20)->default('Draft');
            $table->string('type', 30)->default('Medical');
            $table->date('payment_date')->nullable();
            $table->decimal('patient_responsibility', 14, 2)->default(0);
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['patient_id', 'status']);
            $table->index('invoice_id');
        });

        Schema::create('claim_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_id')->constrained('insurance_claims')->cascadeOnDelete();
            $table->string('name');
            $table->date('date');
            $table->decimal('billed', 14, 2);
            $table->decimal('allowed', 14, 2)->nullable();
            $table->decimal('patient_resp', 14, 2)->default(0);
            $table->timestamps();
            $table->index('claim_id');
        });

        Schema::create('insurance_communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_id')->constrained('insurance_claims')->cascadeOnDelete();
            $table->string('direction', 10)->default('out');
            $table->string('message_type', 30);
            $table->longText('request_body')->nullable();
            $table->longText('response_body')->nullable();
            $table->string('status_code', 10)->nullable();
            $table->timestamps();
            $table->index('claim_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_communications');
        Schema::dropIfExists('claim_services');
        Schema::dropIfExists('insurance_claims');
        Schema::dropIfExists('insurance_providers');
    }
};
