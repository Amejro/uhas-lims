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

        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->timestamp('collection_date');
            $table->string('active_ingredient')->nullable();
            $table->string('delivered_by');
            $table->string('deliverer_contact');
            $table->string('indication')->nullable();
            $table->enum('status', ["collected", "in_progress", "completed", "approved"])->default('collected');
            $table->string('dosage')->nullable();
            $table->timestamp('date_of_manufacture')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->string('batch_number')->nullable();
            $table->string('serial_code')->unique();
            // $table->foreignId('storage_location_id')->constrained()->nullOnDelete();
            // $table->foreignId('dosage_form_id')->constrained()->nullOnDelete();
            // $table->foreignId('user_id')->constrained()->nullOnDelete();
            // $table->foreignId('producer_id')->constrained()->nullOnDelete();

            $table->unsignedBigInteger('storage_location_id');
            $table->foreign('storage_location_id')->references('id')->on('storage_locations')->onDelete(null);

            $table->unsignedBigInteger('dosage_form_id');
            $table->foreign('dosage_form_id')->references('id')->on('dosage_forms')->onDelete(null);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete(null);

            $table->unsignedBigInteger('producer_id');
            $table->foreign('producer_id')->references('id')->on('producers')->onDelete(null);

            $table->boolean('inventory_updated')->default(false);
            $table->integer('total_cost')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
