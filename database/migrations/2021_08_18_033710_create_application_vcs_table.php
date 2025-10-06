<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationVcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_vcs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('application_id')->unsigned()->index();
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->bigInteger('status_vc_id')->unsigned()->index();
            $table->foreign('status_vc_id')->references('id')->on('status_vcs')->onDelete('cascade');
            $table->boolean('webex');
            $table->string('nama_aplikasi')->nullable();
            $table->boolean('peralatan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('link_webex')->nullable();
            $table->string('id_webex')->nullable();
            $table->string('password_webex')->nullable();
            $table->datetime('password_expired')->nullable();
            $table->text('catatan_penyelia')->nullable();
            $table->string('keputusan')->nullable();
            $table->datetime('tarikh_keputusan')->nullable();
            $table->datetime('tarikh_mohon_batal')->nullable();
            $table->datetime('tarikh_batal')->nullable();
            $table->text('komen_ditolak')->nullable();
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
        Schema::dropIfExists('application_vcs');
    }
}
