<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Billing: invoices + invoice_items + invoice_services.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->date('due_date')->nullable();
            $table->decimal('amount', 14, 2)->default(0);
            $table->decimal('paid_amount', 14, 2)->default(0);
            $table->decimal('balance', 14, 2)->default(0);
            $table->string('currency', 3)->default('UGX');
            $table->string('status', 20)->default('Unpaid');
            $table->string('insurance_status', 30)->default('Not Submitted');
            $table->string('insurance_provider')->nullable();
            $table->string('insurance_policy', 100)->nullable();
            $table->string('insurance_group', 100)->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_reference', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'status', 'date']);
            $table->index('patient_id');
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->text('additional_desc')->nullable();
            $table->unsignedInteger('qty')->default(1);
            $table->decimal('unit_price', 14, 2);
            $table->decimal('total', 14, 2);
            $table->timestamps();
            $table->index('invoice_id');
        });

        Schema::create('invoice_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->nullable();
            $table->decimal('billed', 14, 2);
            $table->decimal('allowed', 14, 2)->nullable();
            $table->decimal('patient_resp', 14, 2)->default(0);
            $table->timestamps();
            $table->index('invoice_id');
        });

        // Note: services table created later; FK added in services migration
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_services');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
