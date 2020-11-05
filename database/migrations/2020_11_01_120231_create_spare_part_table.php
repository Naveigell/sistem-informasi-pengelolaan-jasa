<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('spare_part')) {
            Schema::create('spare_part', function (Blueprint $table) {
                $table->bigIncrements('id_spare_part');
                $table->string('nama_spare_part', 120);
                $table->text('deskripsi')->nullable();
                $table->enum('tipe', ['hp', 'pc/komputer', 'printer']);
                $table->unsignedSmallInteger('stok');
                $table->unsignedInteger('terjual');
                $table->unsignedInteger('harga');
                $table->timestamps();
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
        Schema::dropIfExists('spare_part');
    }
}
