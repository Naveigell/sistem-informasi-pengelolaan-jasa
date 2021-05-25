<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()  {

        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id_users');
                $table->string('name', 60);
                $table->string('username', 40)->unique();
                $table->string('email')->unique();
                $table->string('password');
                $table->enum('role', ['admin', 'teknisi', 'pelanggan']);
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
