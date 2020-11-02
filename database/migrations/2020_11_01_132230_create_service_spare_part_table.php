<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceSparePartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('service_spare_part')) {
            Schema::create('service_spare_part', function (Blueprint $table) {
                $table->bigIncrements('id_service_hardware');
                $table->unsignedBigInteger('service_hardware_id')->nullable()->index();
                $table->smallInteger('jumlah');
                $table->unsignedInteger('harga');
                $table->timestamps();

                // foreign
                $table->foreign('service_hardware_id')->references('id_spare_part')->on('spare_part')->onUpdate('cascade')->onDelete('SET NULL');
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
        Schema::dropIfExists('service_spare_part');
    }
}
