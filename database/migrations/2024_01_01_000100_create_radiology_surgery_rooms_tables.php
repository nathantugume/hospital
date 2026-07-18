<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Radiology orders, surgeries, rooms, room_allotments.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('radiology_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->enum('modality', ['CT', 'MRI', 'X-Ray', 'Ultrasound', 'Mammography', 'Fluoroscopy', 'DEXA']);
            $table->string('body_part', 255);
            $table->string('priority', 20)->default('Routine');
            $table->string('status', 20)->default('Pending');
            $table->foreignId('referring_doctor_id')->nullable();
            $table->foreignId('radiologist_id')->nullable();
            $table->date('order_date');
            $table->date('scheduled_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->string('room', 100)->nullable();
            $table->string('report_status', 20)->nullable();
            $table->text('report_findings')->nullable();
            $table->string('attachment_url')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'status']);
            $table->index('order_date');
        });

        Schema::table('radiology_orders', function (Blueprint $table) {
            $table->foreign('referring_doctor_id')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('radiologist_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('surgeries', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('procedure');
            $table->string('ot_room', 50);
            $table->string('room_name', 100)->nullable();
            $table->foreignId('surgeon_id')->nullable();
            $table->foreignId('anesthesiologist_id')->nullable();
            $table->foreignId('nurse_id')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('status', 20)->default('Scheduled');
            $table->string('priority', 20)->default('Normal');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['patient_id', 'date']);
        });

        Schema::table('surgeries', function (Blueprint $table) {
            $table->foreign('surgeon_id')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('anesthesiologist_id')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('nurse_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('number', 20)->unique();
            $table->string('type', 30)->default('General');
            $table->string('status', 20)->default('Available');
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('ward_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('capacity')->nullable();
            $table->text('equipment')->nullable();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('doctor_id')->nullable();
            $table->timestamps();
            $table->index(['status', 'type']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('room_allotments', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->string('room_number', 20)->nullable();
            $table->string('room_type', 50)->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->date('allotment_date');
            $table->date('discharge_date')->nullable();
            $table->string('status', 20)->default('Occupied');
            $table->foreignId('doctor_id')->nullable();
            $table->decimal('daily_rate', 14, 2)->nullable();
            $table->string('currency', 3)->default('UGX');
            $table->boolean('insurance_verified')->default(false);
            $table->timestamps();
            $table->index(['patient_id', 'status']);
            $table->index('room_id');
        });

        Schema::table('room_allotments', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_allotments');
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
        });
        Schema::dropIfExists('rooms');
        Schema::table('surgeries', function (Blueprint $table) {
            $table->dropForeign(['surgeon_id']);
            $table->dropForeign(['anesthesiologist_id']);
            $table->dropForeign(['nurse_id']);
        });
        Schema::dropIfExists('surgeries');
        Schema::table('radiology_orders', function (Blueprint $table) {
            $table->dropForeign(['referring_doctor_id']);
            $table->dropForeign(['radiologist_id']);
        });
        Schema::dropIfExists('radiology_orders');
    }
};
