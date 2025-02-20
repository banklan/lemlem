<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuisineReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuisine_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('cuisine_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->string('comments');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('cuisine_id')->references('id')->on('cuisines');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuisine_reviews');
    }
}
