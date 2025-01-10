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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit');
            $table->integer('base_size')->default(0);
            $table->json('ingredient')->nullable();
            $table->text('description')->nullable();
            // $table->foreignId('user_id')->constrained();
            // $table->foreignId('storage_location_id')->constrained()->nullOnDelete();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete(null);

            $table->unsignedBigInteger('storage_location_id');
            $table->foreign('storage_location_id')->references('id')->on('storage_locations')->onDelete(null);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
