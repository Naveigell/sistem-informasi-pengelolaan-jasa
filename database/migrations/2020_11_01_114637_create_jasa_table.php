<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJasaTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('jasa')) {
            Schema::create('jasa', function (Blueprint $table) {
                $table->bigIncrements('id_jasa');
                $table->string('nama_jasa', 30);
                $table->string('deskripsi', 255);
                $table->enum('tipe', ['hp', 'pc/komputer', 'printer']);
                $table->mediumInteger('biaya_jasa')->unsigned();
                $table->boolean("aktif")->unsigned()->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()  {
        Schema::dropIfExists('jasa');
    }
}
