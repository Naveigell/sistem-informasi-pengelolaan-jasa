<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersSparePartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('orders_spare_part')) {
            Schema::create('orders_spare_part', function (Blueprint $table) {
                $table->bigIncrements('id_orders_spare_part');
                $table->unsignedBigInteger('orders_spare_part_id_spare_part')->nullable()->index();
                $table->unsignedBigInteger('orders_spare_part_id_orders')->nullable()->index();
                $table->string('nama_spare_part', 120);
                $table->string('part_number', 50)->nullable();
                $table->string('serial_number', 50)->nullable();
                $table->unsignedSmallInteger('jumlah');
                $table->unsignedInteger('harga_asli');
                $table->unsignedInteger('harga');
                $table->timestamps();

                // foreign
                $table->foreign('orders_spare_part_id_spare_part')->references('id_spare_part')->on('spare_part')->onUpdate('cascade')->onDelete('SET NULL');
                $table->foreign('orders_spare_part_id_orders')->references('id_orders')->on('orders')->onUpdate('cascade')->onDelete('SET NULL');
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
        Schema::dropIfExists('orders_spare_part');
    }
}
