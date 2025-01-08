<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('unit')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->integer('restock_quantity')->nullable();
            $table->integer('reorder_level')->default(0);
            $table->timestamp('expiry_date');
            $table->enum('status', ["available", "out_of_stock"]);
            $table->json('item_variant')->nullable();
            $table->foreignId('storage_location_id')->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('total_quantity');
            $table->foreignId('inventory_id')->constrained()->nullable()->nullOnDelete();
            $table->json('item_variant')->nullable();
            $table->enum('action', ["addition", "deduction"]);
            $table->foreignId('user_id')->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_histories');

        Schema::dropIfExists('inventories');
    }
};
