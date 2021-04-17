<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pengaduan')) {
            Schema::create('pengaduan', function (Blueprint $table) {
                $table->bigIncrements('id_pengaduan');
                $table->unsignedBigInteger('pengaduan_id_users')->nullable()->index();
                $table->unsignedBigInteger('pengaduan_id_teknisi')->nullable()->index();
                $table->text('isi')->nullable();
                $table->text('balasan')->nullable();
                $table->unsignedTinyInteger('stars')->default(3);
                $table->enum('tipe', ['saran', 'komplain']);
                $table->timestamps();

                // foreign
                $table->foreign('pengaduan_id_users')->on('users')->references('id_users')->onUpdate('CASCADE')->onDelete('SET NULL');
                $table->foreign('pengaduan_id_teknisi')->on('users')->references('id_users')->onUpdate('CASCADE')->onDelete('SET NULL');
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
        Schema::dropIfExists('pengaduan');
    }
}
