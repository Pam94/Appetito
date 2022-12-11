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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id('ingredientId');
            $table->string('name');
            $table->binary('icon')->nullable();
            $table->boolean('pantry');
            $table->boolean('shoplist');
            $table->foreignId('user_id');
            $table->foreignId('ingredientCategoryId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
};
