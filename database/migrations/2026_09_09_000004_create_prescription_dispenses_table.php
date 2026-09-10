<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('medicine_transactions', function (Blueprint $table): void { $table->foreignId('medicine_batch_id')->nullable()->after('medicine_id')->constrained('medicine_batches')->nullOnDelete(); });
        Schema::create('prescription_dispenses', function (Blueprint $table): void {
            $table->id(); $table->foreignId('prescription_id')->constrained()->cascadeOnDelete(); $table->foreignId('prescription_item_id')->unique()->constrained()->cascadeOnDelete(); $table->foreignId('medicine_id')->constrained()->cascadeOnDelete(); $table->foreignId('medicine_batch_id')->constrained('medicine_batches'); $table->unsignedInteger('quantity'); $table->foreignId('patient_id')->constrained()->cascadeOnDelete(); $table->foreignId('dispensed_by')->nullable()->constrained('users')->nullOnDelete(); $table->timestamp('dispensed_at'); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('prescription_dispenses'); Schema::table('medicine_transactions', function (Blueprint $table): void { $table->dropForeign(['medicine_batch_id']); $table->dropColumn('medicine_batch_id'); }); }
};
