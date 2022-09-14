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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('character');
            $table->string('item');
            $table->integer('amount');
            $table->integer('durability');
            $table->integer('ammo');
            $table->string('metadata');

            $table->dateTime('time');

            $table->integer('bid');
            $table->integer('price');
            $table->string('bidder');
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
        Schema::dropIfExists('lots');
    }
};
