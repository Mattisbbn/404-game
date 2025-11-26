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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('username');
            $table->foreignId('lobby_id')->constrained('lobbies')->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->string('status')->default('waiting');
            $table->string('color')->default('purple');
            $table->integer('order')->default(0);
            $table->integer('position')->default(0);
            $table->boolean('is_current')->default(false);
            $table->boolean('canRoll')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
