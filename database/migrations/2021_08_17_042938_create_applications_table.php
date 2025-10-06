<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('batch_id')->unsigned()->index();
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('room_id')->unsigned()->index();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->string('nama_mesyuarat');
            $table->datetime('tarikh_mula');
            $table->datetime('tarikh_hingga');
            $table->datetime('tarikh_mohon_batal')->nullable();
            $table->datetime('tarikh_batal')->nullable();
            $table->string('komen_batal')->nullable();
            $table->string('kategori_pengerusi');
            $table->string('nama_pengerusi')->nullable();
            $table->string('bilangan_tempahan');
            $table->string('perakuan');
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
        Schema::dropIfExists('applications');
    }
}
