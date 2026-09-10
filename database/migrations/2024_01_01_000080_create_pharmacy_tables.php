<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pharmacy: medicines, medicine_batches, medicine_transactions,
 * prescriptions, prescription_items, medication_administrations.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('category', 100)->nullable();
            $table->enum('type', ['prescription', 'otc', 'controlled'])->default('prescription');
            $table->string('manufacturer', 255)->nullable();
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->string('currency', 3)->default('UGX');
            $table->integer('stock')->default(0);
            $table->integer('reorder_level')->default(50);
            $table->date('expiry')->nullable();
            $table->string('status', 20)->default('In Stock');
            $table->string('barcode', 100)->nullable();
            $table->timestamps();
            $table->index(['status', 'stock']);
            $table->index('expiry');
        });

        Schema::create('medicine_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
            $table->string('batch_number', 100);
            $table->date('mfg_date')->nullable();
            $table->date('expiry_date');
            $table->integer('quantity')->default(0);
            $table->string('status', 20)->default('Active');
            $table->timestamps();
            $table->index(['medicine_id', 'expiry_date']);
        });

        Schema::create('medicine_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('type', 30)->default('Dispensed');
            $table->integer('quantity');
            $table->string('reference', 100)->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('user_name', 255)->nullable();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('supplier_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['medicine_id', 'date']);
        });

        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable();
            $table->date('date');
            $table->string('status', 20)->default('Active');
            $table->integer('refills')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['patient_id', 'status']);
        });

        Schema::table('prescriptions', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained()->cascadeOnDelete();
            $table->string('medication');
            $table->foreignId('medicine_id')->nullable()->constrained()->nullOnDelete();
            $table->string('dosage', 50);
            $table->string('frequency', 100);
            $table->string('route', 30)->default('Oral');
            $table->integer('duration')->nullable();
            $table->string('duration_unit', 10)->default('Days');
            $table->text('instructions')->nullable();
            $table->integer('refills_allowed')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->index('prescription_id');
        });

        Schema::create('medication_administrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('medication');
            $table->foreignId('medicine_id')->nullable()->constrained()->nullOnDelete();
            $table->string('dosage', 50);
            $table->time('scheduled_time');
            $table->timestamp('administered_at')->nullable();
            $table->string('status', 20)->default('Pending');
            $table->foreignId('administered_by')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medication_administrations');
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
        });
        Schema::dropIfExists('prescription_items');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('medicine_transactions');
        Schema::dropIfExists('medicine_batches');
        Schema::dropIfExists('medicines');
    }
};
