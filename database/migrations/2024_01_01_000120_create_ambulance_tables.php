<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Ambulance: ambulances + ambulance_calls + gps_positions.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('reg_no', 20)->unique();
            $table->string('model', 100);
            $table->year('year');
            $table->string('type', 50)->default('Basic Life Support');
            $table->string('status', 20)->default('Available');
            $table->foreignId('driver_id')->nullable();
            $table->string('driver_name', 255)->nullable();
            $table->string('location', 100)->nullable();
            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();
            $table->string('mileage', 50)->nullable();
            $table->string('fuel_type', 20)->nullable();
            $table->integer('capacity_stretchers')->nullable();
            $table->integer('capacity_seated')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->text('equipment')->nullable();
            $table->timestamps();
            $table->index(['status', 'location']);
        });

        Schema::table('ambulances', function (Blueprint $table) {
            $table->foreign('driver_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('ambulance_calls', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('ambulance_id')->nullable()->constrained()->nullOnDelete();
            $table->string('caller_name', 255);
            $table->string('patient_name', 255)->nullable();
            $table->text('pickup_location');
            $table->text('destination')->nullable();
            $table->timestamp('call_time')->useCurrent();
            $table->timestamp('dispatch_time')->nullable();
            $table->timestamp('arrival_time')->nullable();
            $table->string('status', 20)->default('Dispatched');
            $table->string('priority', 20)->default('Emergency');
            $table->string('severity', 20)->default('Yellow')->comment('Red, Orange, Yellow, Green');
            $table->decimal('pickup_lat', 10, 7)->nullable();
            $table->decimal('pickup_lng', 10, 7)->nullable();
            $table->decimal('current_lat', 10, 7)->nullable();
            $table->decimal('current_lng', 10, 7)->nullable();
            $table->foreignId('driver_id')->nullable();
            $table->foreignId('dispatcher_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['status', 'priority']);
        });

        Schema::table('ambulance_calls', function (Blueprint $table) {
            $table->foreign('driver_id')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('dispatcher_id')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('ambulance_gps_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ambulance_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ambulance_call_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->decimal('speed', 6, 2)->nullable()->comment('km/h');
            $table->decimal('heading', 5, 2)->nullable()->comment('degrees 0-360');
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
            $table->index(['ambulance_id', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ambulance_gps_positions');
        Schema::table('ambulance_calls', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
            $table->dropForeign(['dispatcher_id']);
        });
        Schema::dropIfExists('ambulance_calls');
        Schema::table('ambulances', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
        });
        Schema::dropIfExists('ambulances');
    }
};
