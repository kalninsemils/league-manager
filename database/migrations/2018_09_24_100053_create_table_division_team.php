<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDivisionTeam extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('division_team', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('division_id')->unsigned();
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->integer('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('division_team');
    }
}
