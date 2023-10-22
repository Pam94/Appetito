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
         * pair of 'recipe_id' and 'ingredient_id' so the id of the table
         * it doesn't have to be an UUID
         */
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('recipe_id');
            $table->foreignUuid('ingredient_id');
            $table->tinyInteger('grams');
            $table->unique(['recipe_id', 'ingredient_id']);
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
        Schema::dropIfExists('ingredient_recipe');
    }
};
