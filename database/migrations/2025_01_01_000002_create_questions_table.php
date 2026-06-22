<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->constrained()->cascadeOnDelete();
            $table->enum('level', ['A1', 'A2', 'B1', 'B2'])->index();
            $table->text('prompt');
            $table->text('sample_answer')->nullable();
            $table->text('tips')->nullable();
            $table->json('vocabulary')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['theme_id', 'level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
