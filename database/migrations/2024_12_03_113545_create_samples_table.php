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
            $table->enum('status', ["collected", "in_progress", "completed"]);
            $table->string('dosage')->nullable();
            $table->timestamp('date_of_manufacture');
            $table->timestamp('expiry_date');
            $table->string('batch_number')->nullable();
            $table->string('serial_code')->unique();
            $table->foreignId('storage_location_id')->constrained();
            $table->foreignId('dosage_form_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('producer_id')->constrained();
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
