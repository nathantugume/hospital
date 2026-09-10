<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Inventory: inventory_items, suppliers, supplier_products, purchase_orders,
 * order_tracking_events, inventory_transfers, inventory_transfer_items,
 * inventory_transfer_dispatches, inventory_transfer_history.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('category', 100)->nullable();
            $table->string('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('location', 100)->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->string('status', 20)->default('Active');
            $table->boolean('preferred')->default(false);
            $table->string('delivery_rate', 20)->nullable();
            $table->string('lead_time', 50)->nullable();
            $table->integer('items_count')->default(0);
            $table->timestamps();
            $table->index(['status', 'preferred']);
        });

        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('category', 100)->nullable();
            $table->integer('stock_current')->default(0);
            $table->integer('min_level')->default(0);
            $table->integer('max_level')->nullable();
            $table->integer('reorder_level')->nullable();
            $table->string('status', 20)->default('In Stock');
            $table->string('unit', 20)->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('supplier_item_code', 100)->nullable();
            $table->decimal('supplier_price', 14, 2)->nullable();
            $table->string('currency', 3)->default('UGX');
            $table->integer('lead_time_days')->nullable();
            $table->integer('min_order_qty')->nullable();
            $table->date('last_updated')->nullable();
            $table->string('barcode', 100)->nullable();
            $table->timestamps();
            $table->index(['status', 'stock_current']);
            $table->index('supplier_id');
        });

        Schema::table('medicine_transactions', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
        });

        Schema::create('supplier_products', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('category', 100)->nullable();
            $table->decimal('price', 14, 2);
            $table->string('currency', 3)->default('UGX');
            $table->string('lead_time', 50)->nullable();
            $table->string('min_order', 50)->nullable();
            $table->timestamps();
            $table->index('supplier_id');
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('item');
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 14, 2);
            $table->decimal('amount', 14, 2);
            $table->string('currency', 3)->default('UGX');
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
            $table->string('status', 20)->default('Pending');
            $table->string('priority', 20)->default('Normal');
            $table->string('tracking_number', 100)->nullable();
            $table->string('carrier', 100)->nullable();
            $table->timestamps();
            $table->index(['supplier_id', 'status']);
        });

        Schema::create('order_tracking_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();
            $table->timestamp('date');
            $table->string('location', 255)->nullable();
            $table->string('status', 100);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index('purchase_order_id');
        });

        Schema::create('inventory_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('from_location', 100);
            $table->string('to_location', 100);
            $table->text('items')->nullable();
            $table->unsignedInteger('qty')->default(0);
            $table->date('date');
            $table->string('status', 20)->default('Draft');
            $table->foreignId('requested_by')->nullable();
            $table->foreignId('approved_by')->nullable();
            $table->foreignId('rejected_by')->nullable();
            $table->foreignId('dispatched_by')->nullable();
            $table->foreignId('received_by')->nullable();
            $table->foreignId('cancelled_by')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();
            $table->index(['status', 'date']);
        });

        Schema::table('inventory_transfers', function (Blueprint $table) {
            $table->foreign('requested_by')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('rejected_by')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('dispatched_by')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('received_by')->references('id')->on('staff')->nullOnDelete();
            $table->foreign('cancelled_by')->references('id')->on('staff')->nullOnDelete();
        });

        Schema::create('inventory_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('inventory_transfers')->cascadeOnDelete();
            $table->string('item_name');
            $table->string('batch', 100)->nullable();
            $table->unsignedInteger('qty');
            $table->string('unit', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('inventory_transfer_dispatches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('inventory_transfers')->cascadeOnDelete();
            $table->foreignId('dispatched_by')->nullable();
            $table->date('dispatch_date');
            $table->string('transport_method', 50)->nullable();
            $table->date('estimated_delivery')->nullable();
            $table->string('tracking_number', 100)->nullable();
            $table->string('packed_by', 255)->nullable();
            $table->text('dispatch_notes')->nullable();
            $table->boolean('urgent_dispatch')->default(false);
            $table->boolean('notify_receiver')->default(false);
            $table->unsignedInteger('total_items')->default(0);
            $table->unsignedInteger('total_qty')->default(0);
            $table->string('status', 20)->default('Dispatched');
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamps();
        });

        Schema::table('inventory_transfer_dispatches', function (Blueprint $table) {
            $table->foreign('dispatched_by')->references('id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transfer_dispatches');
        Schema::dropIfExists('inventory_transfer_items');
        Schema::table('inventory_transfers', function (Blueprint $table) {
            $table->dropForeign(['requested_by']);
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);
            $table->dropForeign(['dispatched_by']);
            $table->dropForeign(['received_by']);
            $table->dropForeign(['cancelled_by']);
        });
        Schema::dropIfExists('inventory_transfers');
        Schema::dropIfExists('order_tracking_events');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('supplier_products');
        Schema::table('medicine_transactions', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('suppliers');
    }
};
