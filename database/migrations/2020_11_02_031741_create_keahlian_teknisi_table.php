<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeahlianTeknisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (Schema::hasTable('keahlian_teknisi')) {
            Schema::create('keahlian_teknisi', function (Blueprint $table) {
                $table->bigIncrements('id_keahlian_teknisi');
                $table->bigInteger('keahlian_teknisi_id_users')->unique()->index();
                $table->enum('keahlian', [
                    'instalasi_printer', 'perbaikan_printer', 'pembersihan_printer',
                    'instalasi_pc', 'perbaikan_pc', 'pembersihan_pc',
                    'perbaikan_hp'
                ]);
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
        Schema::dropIfExists('keahlian_teknisi');
    }
}
