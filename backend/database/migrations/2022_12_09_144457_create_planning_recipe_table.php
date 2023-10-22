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
        /**
         * The records in the table are unequivocally identified by the unique
         * trio of 'recipe_id', 'planning_id' and 'meal' so the id of the table
         * it doesn't have to be an UUID
         */
        Schema::create('planning_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_id');
            $table->foreignUuid('recipe_id');
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
