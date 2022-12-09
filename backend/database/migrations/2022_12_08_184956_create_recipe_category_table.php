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
        Schema::create('recipe_category', function (Blueprint $table) {
            $table->id('recipeCategoryId');
            $table->foreignId('recipeId')->constrained();
            $table->foreignId('categoryId')->constrained();
            $table->unique(['recipeId', 'categoryId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_category');
    }
};
