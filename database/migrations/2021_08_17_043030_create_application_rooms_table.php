<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('application_id')->unsigned()->index();
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->bigInteger('status_room_id')->unsigned()->index();
            $table->foreign('status_room_id')->references('id')->on('status_rooms')->onDelete('cascade');
            $table->string('nama_urusetia');
            $table->bigInteger('position_id')->unsigned()->index();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->bigInteger('department_id')->unsigned()->index();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->string('emel_urusetia');
            $table->string('no_extension_urusetia', 4);
            $table->string('no_telefon_bimbit_urusetia', 12);
            $table->string('kategori_mesyuarat');
            $table->string('surat')->nullable();
            $table->string('penganjur');
            $table->string('nama_penganjur')->nullable();
            $table->string('ahli')->nullable();
            $table->string('sajian');
            $table->string('minum_pagi')->nullable();
            $table->string('makan_tengahari')->nullable();
            $table->string('minum_petang')->nullable();
            $table->text('catatan')->nullable();
            $table->text('catatan_penyelia')->nullable();
            $table->text('komen_ditolak')->nullable();
            $table->string('keputusan')->nullable();
            $table->datetime('tarikh_keputusan')->nullable();
            $table->datetime('tarikh_mohon_batal')->nullable();
            $table->datetime('tarikh_batal')->nullable();
            $table->timestamps();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('action_by')->nullable();
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
        Schema::dropIfExists('application_rooms');
    }
}
