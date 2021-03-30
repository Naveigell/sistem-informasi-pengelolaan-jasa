<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('service')) {
            Schema::create('service', function (Blueprint $table) {
                $table->bigIncrements('id_service');
                $table->unsignedBigInteger('service_id_teknisi')->nullable()->index();
                $table->unsignedBigInteger('service_id_jasa')->nullable()->index();
                $table->unsignedBigInteger('service_id_user')->nullable()->index();
                $table->string('unique_id', 255)->unique()->index();
                $table->string('nama_pemilik', 40);
                $table->string('alamat_pemilik', 90);
                $table->string("nama_perangkat", 50);
                $table->text('keluhan');
                $table->enum('jenis_perangkat', ['hp', 'pc/komputer', 'printer']);
                $table->string('merk', 70);
                $table->integer('biaya_jasa')->nullable();
                $table->enum('status_service', ['menunggu', 'dicek', 'perbaikan', 'selesai', 'pembayaran', 'terima'])->default("menunggu");
                $table->dateTime('tanggal_pengecekan')->nullable();
                $table->dateTime('tanggal_selesai')->nullable();
                $table->unsignedSmallInteger('estimasi_selesai')->nullable();
                $table->timestamps();

                $table->foreign('service_id_teknisi')->references('id_users')->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
                $table->foreign('service_id_user')->references('id_users')->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
                $table->foreign('service_id_jasa')->references('id_jasa')->on('jasa')->onUpdate('CASCADE')->onDelete('SET NULL');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service');
    }
}
