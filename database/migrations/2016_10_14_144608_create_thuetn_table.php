<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThuetnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thuetn', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mahh')->nullable();
            $table->string('tenhh')->nullable();
            $table->string('masopnhom')->nullable();
            $table->string('maloaihh')->nullable();
            $table->string('maloaigia')->nullable();
            $table->string('thitruong')->nullable();
            $table->string('thoigian')->nullable();
            $table->string('mathoidiem')->nullable();
            $table->double('giatu')->default(0);
            $table->double('giaden')->default(0);
            $table->double('giatn')->default(0);
            $table->string('dvt')->nullable();
            $table->string('nguontin')->nullable();
            $table->string('gc')->nullable();
            $table->string('mahs')->nullable();
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
        Schema::drop('thuetn');
    }
}
