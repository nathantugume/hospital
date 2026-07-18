<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Communication: calendar_events, notifications, chat_threads, chat_messages.
 * Super-admin: role_assignments, role_change_log, audit_logs.
 * Integration support: sms_logs, mobile_money_transactions, national_id_verifications.
 */
return new class extends Migration {
    public function up(): void
    {
        // --- Calendar events ---
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('category', 50)->default('appointment');
            $table->date('date');
            $table->string('start_time', 10);
            $table->string('end_time', 10)->nullable();
            $table->string('location', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'date']);
        });

        // --- Notifications ---
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 100)->nullable();
            $table->string('title');
            $table->text('message');
            $table->string('category', 50)->default('system');
            $table->boolean('is_read')->default(false);
            $table->string('action_url')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'is_read']);
        });

        // --- Chat threads + messages ---
        Schema::create('chat_threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 255);
            $table->string('role', 100)->nullable();
            $table->string('avatar', 10)->nullable();
            $table->unsignedInteger('unread_count')->default(0);
            $table->text('last_message')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->string('status', 20)->default('offline');
            $table->boolean('is_group')->default(false);
            $table->boolean('is_blocked')->default(false);
            $table->timestamps();
            $table->index('user_id');
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('chat_threads')->cascadeOnDelete();
            $table->foreignId('sender_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('sender', 10)->default('me');
            $table->text('text');
            $table->timestamp('sent_at')->useCurrent();
            $table->boolean('read')->default(false);
            $table->timestamps();
            $table->index('thread_id');
        });

        // --- Role assignments (super-admin) ---
        Schema::create('role_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->string('staff_name', 255)->nullable();
            $table->string('email')->nullable();
            $table->text('roles')->nullable();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('last_updated')->useCurrent();
            $table->string('status', 20)->default('Active');
            $table->timestamps();
            $table->index(['user_id', 'status']);
        });

        Schema::create('role_change_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name', 255)->nullable();
            $table->string('prev_role', 100);
            $table->string('new_role', 100);
            $table->timestamp('date')->useCurrent();
            $table->timestamps();
        });

        // --- Audit logs ---
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('user_name', 255)->nullable();
            $table->string('action', 50);
            $table->string('entity', 255)->nullable();
            $table->string('entity_id', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'timestamp']);
            $table->index('action');
        });

        // --- SMS logs ---
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('message_id', 100)->nullable();
            $table->text('to_phone');
            $table->string('recipient_name', 255)->nullable();
            $table->text('message');
            $table->string('sender_id', 50)->nullable();
            $table->string('provider', 30)->default('africas_talking');
            $table->string('status', 30)->default('queued');
            $table->string('status_code', 10)->nullable();
            $table->decimal('cost', 8, 4)->nullable();
            $table->string('currency', 3)->default('UGX');
            $table->string('category', 50)->nullable()->comment('appointment_reminder, lab_result, ambulance_dispatch, invoice_due, prescription_ready, 2fa, welcome');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('staff_id')->nullable()->constrained()->nullOnDelete();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'category']);
            $table->index('patient_id');
        });

        // --- Mobile money transactions ---
        Schema::create('mobile_money_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('provider', 20)->comment('mtn, airtel, mpesa');
            $table->string('provider_reference', 100)->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->string('status', 30)->default('initiated');
            $table->string('direction', 20)->default('collection')->comment('collection, disbursement');
            $table->decimal('amount', 14, 2);
            $table->string('currency', 3)->default('UGX');
            $table->text('payer_phone');
            $table->string('payer_name', 255)->nullable();
            $table->string('payee_note', 255)->nullable();
            $table->string('payment_reason', 255)->nullable();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->text('request_payload')->nullable();
            $table->text('response_payload')->nullable();
            $table->text('callback_payload')->nullable();
            $table->timestamp('initiated_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
            $table->index(['status', 'provider']);
            $table->index('invoice_id');
        });

        // --- National ID verifications ---
        Schema::create('national_id_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('verification_id', 100)->nullable();
            // National IDs are short identifiers and need a bounded length for the composite index below.
            $table->string('national_id', 100)->nullable();
            $table->string('country', 50)->default('Uganda');
            $table->string('provider', 30)->default('NIRA')->comment('NIRA, NIIMS, NIDA, NIDA_Rwanda');
            $table->string('full_name', 255)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('photo_url', 500)->nullable();
            $table->string('status', 20)->default('pending');
            $table->text('request_payload')->nullable();
            $table->text('response_payload')->nullable();
            $table->text('error_message')->nullable();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->index(['national_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('national_id_verifications');
        Schema::dropIfExists('mobile_money_transactions');
        Schema::dropIfExists('sms_logs');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('role_change_log');
        Schema::dropIfExists('role_assignments');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_threads');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('calendar_events');
    }
};
