<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password');
            $table->dateTime('lastLogin')->nullable();
            $table->boolean('banned')->default(false);
            $table->string('image')->default('user.png');
            $table->string('banner')->nullable();
            $table->string('settings')->default('{"profileAchievements":"1","profileTalents":"1","profileInventory":"1","profileFriends":"1","indexAnnouncements":"1","indexWeb":"1","indexUnity":"1","indexOnline":"1","navAuction":"1","navGuides":"1","navMap":"1","navFaction":"1"}');
            $table->rememberToken();
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
        Schema::dropIfExists('accounts');
    }
};
