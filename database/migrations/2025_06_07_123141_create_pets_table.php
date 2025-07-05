<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shelter_id'); // Shelter user who added the pet
            $table->string('name');                  // Pet name
            $table->string('type');                  // Cat, Dog, etc.
            $table->integer('age');                  // Age in years
            $table->string('behavior')->nullable();  // Friendly, aggressive, calm, etc.
            $table->text('description');             // About the pet
            $table->string('location');              // Google Maps or plain address
            $table->string('image')->nullable();     // Image path
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('shelter_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
