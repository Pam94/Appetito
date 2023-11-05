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
         * pair of 'user_id' and 'date' so the id of the table
         * it doesn't have to be an UUID
         */
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignUuid('user_id')
                  ->constrained('users', 'id')
                  ->onUpdate('cascade');
            $table->unique('date', 'user_id');
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
        Schema::dropIfExists('plannings');
    }
};
