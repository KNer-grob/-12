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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignID("user_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("title");
            $table->string("description");
            $table->enum('difficulty', ["легкий","нормальный","тяжелый"])->default("нормальный");
            $table->foreignId('category')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer("cook_time");
            $table->string("photo");
            $table->boolean('blocked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
