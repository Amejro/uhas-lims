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

        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('content')->nullable();
            $table->foreignId('test_id')->nullable();
            $table->foreignId('dosage_form_id')->nullable();
            $table->foreignId('user_id')->nullable();

            // $table->unsignedBigInteger('test_id');
            // $table->foreign('test_id')->references('id')->on('tests')->onDelete(null)->nullable();

            // $table->unsignedBigInteger('dosage_form_id');
            // $table->foreign('dosage_form_id')->references('id')->on('dosage_forms')->onDelete(null)->nullable();

            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete(null);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
