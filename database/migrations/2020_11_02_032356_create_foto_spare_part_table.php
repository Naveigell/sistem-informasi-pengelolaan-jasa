<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoSparePartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('foto_spare_part')) {
            Schema::create('foto_spare_part', function (Blueprint $table) {
                $table->bigIncrements('id_foto_spare_part');
                $table->unsignedBigInteger('foto_spare_part_id_spare_part')->index();
                $table->string('picture', 255);
                $table->timestamps();

                // foreign
                $table->foreign('foto_spare_part_id_spare_part')->references('id_spare_part')->on('spare_part')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('foto_spare_part');
    }
}
