<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lab_tests', function (Blueprint $table): void { $table->foreignId('company_id')->nullable()->after('id')->constrained()->nullOnDelete(); $table->index(['company_id','status']); });
        Schema::table('lab_equipment', function (Blueprint $table): void { $table->foreignId('company_id')->nullable()->after('id')->constrained()->nullOnDelete(); $table->index(['company_id','status']); });
    }
    public function down(): void
    {
        Schema::table('lab_tests', function (Blueprint $table): void { $table->dropForeign(['company_id']); $table->dropIndex(['company_id','status']); $table->dropColumn('company_id'); });
        Schema::table('lab_equipment', function (Blueprint $table): void { $table->dropForeign(['company_id']); $table->dropIndex(['company_id','status']); $table->dropColumn('company_id'); });
    }
};
