<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('status_pentadbiran')->nullable();
            $table->string('status_pemohon')->nullable();
            $table->string('relate')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status')->default('aktif');
            $table->softDeletes();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_rooms');
    }
}
