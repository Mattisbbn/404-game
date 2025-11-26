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
        Schema::create('gameboard', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('score');
            $table->integer('position');
            $table->enum('category', ['password','phishing','social_media','cyber_risk','']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gameboard');
    }
};
