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
        Schema::create('saves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('slot');
            $table->foreignId('scene_id')->constrained()->cascadeOnDelete();
            $table->integer('step_order')->default(1);
            $table->integer('energy')->default(10);
            $table->integer('alignment')->default(0);
            $table->integer('affection')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'slot']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saves');
    }
};
