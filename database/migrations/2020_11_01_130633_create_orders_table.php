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

        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->bigIncrements('id_orders');
                $table->unsignedBigInteger('orders_id_teknisi')->nullable()->index();
                $table->unsignedBigInteger('orders_id_jasa')->nullable()->index();
                $table->unsignedBigInteger('orders_id_user')->nullable()->index();
                $table->string('unique_id', 255)->unique()->index();
                $table->string('nama_pelanggan', 40);
                $table->string('alamat_pelanggan', 90);
                $table->string("nama_perangkat", 50);
                $table->text('keluhan');
                $table->enum('jenis_perangkat', ['hp', 'pc/komputer', 'printer']);
                $table->string('merk', 70);
                $table->integer('biaya_jasa')->nullable();
                $table->enum('status_service', ['menunggu', 'dicek', 'perbaikan', 'selesai', 'terima'])->default("menunggu");
                $table->timestamps();

                $table->foreign('orders_id_teknisi')->references('id_users')->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
                $table->foreign('orders_id_user')->references('id_users')->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
                $table->foreign('orders_id_jasa')->references('id_jasa')->on('jasa')->onUpdate('CASCADE')->onDelete('SET NULL');
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
        Schema::dropIfExists('orders');
    }
}
