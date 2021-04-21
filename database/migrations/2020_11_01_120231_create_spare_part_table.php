<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
                $table->unsignedInteger('terjual')->default(0);
                $table->unsignedInteger('harga_asli');
                $table->unsignedInteger('harga');
                $table->timestamps();
            });

            // add full text for nama_spare_part
            DB::statement("ALTER TABLE spare_part ADD FULLTEXT full(nama_spare_part)");
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
