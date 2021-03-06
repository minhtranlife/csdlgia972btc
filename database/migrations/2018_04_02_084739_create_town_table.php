<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('town', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mahuyen')->nullable();
            $table->string('maxa')->nullable();
            $table->string('tendv')->nullable();
            $table->string('diachi')->nullable();
            $table->text('ttlienhe')->nullable();
            $table->string('emailql')->nullable();
            $table->string('emailqt')->nullable();
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
        Schema::dropIfExists('town');
    }
}
