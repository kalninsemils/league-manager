<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDivisions extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('league_id')->unsigned();
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }
}
