<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Racquets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('racquets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('team_token');
            $table->string('manufacturer');
            $table->string('type');
            $table->integer('tension_lbs');
            $table->string('string')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('racquets');
    }
}
