<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amends', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('application_id')->unsigned()->nullable();
            $table->foreign('application_id')->references('id')->on('applications');
            //ammend - Rooms
            $table->datetime('tarikh_mula');
            $table->datetime('tarikh_hingga');
            $table->string('bilangan_tempahan');
            $table->string('sajian');
            $table->string('minum_pagi');
            $table->string('makan_tengahari');
            $table->string('minum_petang');
            //ammend - VC
            $table->boolean('webex');
            $table->string('nama_aplikasi');
            $table->boolean('kamera');
            $table->boolean('mikrofon');
            $table->string('speaker');
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->bigInteger('deleted_by')->unsigned()->nullable();
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
        Schema::dropIfExists('amends');
    }
}
