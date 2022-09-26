<?php

use Carbon\Carbon;
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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('account')->nullable();
            $table->string('classname')->default('Player');
            $table->float('x')->default(0);
            $table->float('y')->default(0);
            $table->float('z')->default(0);
            $table->float('yrotation')->default(0);
            $table->Integer('health')->default(0);
            $table->Integer('hydration')->default(0);
            $table->Integer('nutrition')->default(0);
            $table->Integer('temperature')->default(0);
            $table->Integer('endurance')->default(0);

            $table->Integer('level')->default(0);
            $table->Integer('experience')->default(0);
            $table->Integer('gold')->default(0);

            $table->boolean('online')->default(false);
            $table->dateTime('lastsaved')->default(Carbon::now());
            $table->boolean('deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
};
