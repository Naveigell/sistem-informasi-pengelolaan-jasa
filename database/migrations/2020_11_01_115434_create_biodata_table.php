<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiodataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (!Schema::hasTable('biodata')) {
            Schema::create('biodata', function (Blueprint $table) {
                $table->bigIncrements('id_biodata');
                $table->unsignedBigInteger('biodata_id_users')->unique()->index();
                $table->enum('jenis_kelamin', ['Laki - laki', 'Perempuan']);
                $table->string('nomor_hp', 17)->unique();
                $table->string('profile_picture', 255);
                $table->string('alamat', 100);
                $table->timestamps();

                // foreign
                $table->foreign('biodata_id_users')->references('id_users')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('biodata');
    }
}
