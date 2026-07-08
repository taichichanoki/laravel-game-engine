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
        Schema::create('choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scene_id')->constrained()->cascadeOnDelete();
            $table->string('text');
            $table->unsignedBigInteger('next_scene_id');

            $table->integer('min_energy_required')->default(0);
            $table->integer('min_alignment_required')->nullable();
            $table->integer('max_alignment_required')->nullable();
            $table->integer('min_affection_required')->default(0);

            $table->integer('energy_change')->default(0);
            $table->integer('alignment_change')->default(0);
            $table->integer('affection_change')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choices');
    }
};
