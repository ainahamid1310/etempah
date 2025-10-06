<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nama_panjang');
            $table->string('nama_petugas');
            $table->string('no_tel_petugas');
            $table->bigInteger('department_id')->unsigned()->index();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->string('aras');
            $table->string('kapasiti');
            $table->string('is_equipment');
            $table->string('is_projector');
            $table->string('is_upload')->default('0');
            $table->text('keterangan')->nullable();
            $table->boolean('status')->default('1');
            $table->string('email_status')->nullable(); //U - Undefined, Y - Yes, N - No
            $table->string('is_auto');
            $table->string('is_pantry')->nullable()->default('Y');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('rooms');
    }
}
