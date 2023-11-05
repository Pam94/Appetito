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
            $table->uuid('id')->primary();
            $table->string('name', 30);
            $table->boolean('pantry')->default(false);
            $table->boolean('shoplist')->default(false);
            $table->foreignUuid('user_id')
                  ->constrained('users', 'id')
                  ->onUpdate('cascade');
            $table->foreignUuid('ingredient_category_id')
                  ->constrained('ingredient_categories', 'id')
                  ->onUpdate('cascade');
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
        Schema::dropIfExists('ingredients');
    }
};
