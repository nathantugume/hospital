<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * SaaS multi-tenancy: companies (hospital clients) + subscriptions + purchases.
 */
return new class extends Migration {
    public function up(): void
    {
        // ============================================================
        // COMPANIES (SaaS hospital clients)
        // ============================================================
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('url')->nullable();
            $table->string('plan', 50)->default('Essential Care');
            $table->string('contact_person');
            // Stored through Laravel's encrypted cast, so the ciphertext needs more room than a raw phone number.
            $table->text('phone');
            $table->string('country', 50)->default('Uganda');
            $table->string('city', 100);
            $table->text('address')->nullable();
            $table->integer('beds_count')->default(0);
            $table->date('created_on')->nullable();
            $table->string('status', 20)->default('Active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['status', 'plan']);
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('plan', 50);
            $table->string('billing_cycle', 20)->default('Annually');
            $table->string('payment_mode', 30)->nullable();
            $table->decimal('amount', 14, 2)->default(0);
            $table->string('currency', 3)->default('UGX');
            $table->date('created_on');
            $table->date('expiring_on');
            $table->string('status', 20)->default('Active');
            $table->timestamps();
            $table->index(['company_id', 'status']);
        });

        Schema::create('purchase_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('email');
            $table->date('created_on');
            $table->decimal('amount', 14, 2);
            $table->string('currency', 3)->default('UGX');
            $table->string('payment_mode', 30);
            $table->string('status', 20)->default('Completed');
            $table->string('plan', 50)->nullable();
            $table->timestamps();
            $table->index(['company_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_transactions');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('companies');
    }
};
