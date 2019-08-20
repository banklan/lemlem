<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_no')->after('id');
            $table->integer('user_id')->after('order_no');
            $table->integer('cuisine_id')->after('user_id');
            $table->integer('units')->after('cuisine_id');

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
