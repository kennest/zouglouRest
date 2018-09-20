<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('avatar');
            $table->blob("picture");
            $table->string('urlsample');
            $table->timestamps();
        });

        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('picture');
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('commune');
            $table->string('quartier');
            $table->string('lat');
            $table->string('long');
            $table->integer('place_id')->unsigned();
            $table->foreign('place_id')->references('id')->on('places');
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('picture');
            $table->integer('place_id')->unsigned();
            $table->foreign('place_id')
                ->references('id')
                ->on('places')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->dateTime('begin');
            $table->dateTime('end');
            $table->timestamps();
        });

        Schema::create('artist_event',function(Blueprint $table){
            $table->integer('artist_id')->unsigned();
            $table->foreign('artist_id')
                ->references('id')
                ->on('artists')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
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
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_artist_id_foreign');
            $table->dropColumn('artist_id');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_place_id_foreign');
            $table->dropColumn('place_id');
        });

        Schema::drop('events');
        Schema::drop('artists');
        Schema::drop('places');
        Schema::drop('addresses');
    }
}
