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
            $table->id('planningRecipeId');
            $table->foreignId('planningId')->constrained();
            $table->foreignId('recipeId')->constrained();
            $table->enum('meal', ['Desayuno', 'Comida', 'Cena']);
            $table->unique(['planningId', 'recipeId', 'meal']);
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
