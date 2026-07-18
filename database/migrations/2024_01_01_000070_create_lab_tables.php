<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Lab: lab_tests catalog, test_requests (lab orders), lab_results, lab_result_items, lab_equipment.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->string('department', 100)->nullable();
            $table->string('sample_type', 50)->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('currency', 3)->default('UGX');
            $table->decimal('target_turnaround_hours', 5, 1)->nullable();
            $table->string('status', 20)->default('Active');
            $table->timestamps();
            $table->index(['department', 'status']);
        });

        Schema::create('test_requests', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable();
            $table->string('priority', 20)->default('Routine');
            $table->string('status', 30)->default('Pending');
            $table->date('requested_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'status']);
        });

        Schema::table('test_requests', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('lab_request_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lab_test_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('sample_id', 20)->unique()->nullable();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('test_request_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('lab_test_id')->nullable()->constrained()->nullOnDelete();
            $table->string('test_name');
            $table->string('result_value', 100)->nullable();
            $table->string('normal_range', 100)->nullable();
            $table->string('unit', 50)->nullable();
            $table->date('result_date');
            $table->date('collection_date')->nullable();
            $table->string('status', 20)->default('Pending');
            $table->string('flag', 20)->default('Normal');
            $table->foreignId('ordered_by')->nullable();
            $table->foreignId('verified_by')->nullable();
            $table->timestamp('verified_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('sample_type', 50)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('attachment_url')->nullable();
            $table->string('share_token', 64)->nullable();
            $table->timestamp('share_expires_at')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'result_date']);
            $table->index('flag');
            $table->index('ordered_by');
            $table->index('verified_by');
        });

        Schema::table('lab_results', function (Blueprint $table) {
            $table->foreign('ordered_by')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('verified_by')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('lab_result_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_result_id')->constrained()->cascadeOnDelete();
            $table->string('test');
            $table->string('result', 100)->nullable();
            $table->string('range', 100)->nullable();
            $table->string('unit', 50)->nullable();
            $table->string('flag', 20)->default('Normal');
            $table->timestamps();
            $table->index('lab_result_id');
        });

        Schema::create('lab_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('department', 100)->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->string('status', 20)->default('Operational');
            $table->string('location', 100)->nullable();
            $table->string('manufacturer', 255)->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 14, 2)->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->string('service_provider', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'next_maintenance']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_equipment');
        Schema::dropIfExists('lab_result_items');
        Schema::table('lab_results', function (Blueprint $table) {
            $table->dropForeign(['ordered_by']);
            $table->dropForeign(['verified_by']);
        });
        Schema::dropIfExists('lab_results');
        Schema::dropIfExists('lab_request_tests');
        Schema::table('test_requests', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
        });
        Schema::dropIfExists('test_requests');
        Schema::dropIfExists('lab_tests');
    }
};
