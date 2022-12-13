<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planning_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_id');
            $table->foreignId('recipe_id');
            $table->enum('meal', ['Desayuno', 'Comida', 'Cena']);
            $table->unique(['planning_id', 'recipe_id', 'meal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planning_recipe');
    }
};
