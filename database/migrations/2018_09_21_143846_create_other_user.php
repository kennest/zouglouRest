<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('fb_id')->unique();
            $table->string('token');
            $table->string('picture');
            $table->string('gender');
            $table->string('birthday');
            //$table->blob('picture_b64');
            $table->dateTime('date');
            $table->timestamps();
        });

        Schema::create('artist_customer',function(Blueprint $table){
            $table->integer('artist_id')->unsigned();
            $table->foreign('artist_id')
                ->references('id')
                ->on('artists')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('customer_place',function(Blueprint $table){

            $table->integer('place_id')->unsigned();
            $table->foreign('place_id')
                ->references('id')
                ->on('places')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade')
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
        Schema::drop('customers');
    }
}
