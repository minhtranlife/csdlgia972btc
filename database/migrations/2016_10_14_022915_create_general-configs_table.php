<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general-configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tendonvi')->nullable();
            $table->string('maqhns')->nullable();
            $table->string('diachi')->nullable();
            $table->string('tel')->nullable();
            $table->string('diadanh')->nullable();
            $table->text('setting')->nullable();
            $table->text('thongtinhd')->nullable();
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
        Schema::dropIfExists('general-configs');
    }
}
