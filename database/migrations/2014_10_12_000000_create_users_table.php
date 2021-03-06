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
    public function up()
    {
        // Schema::create('users', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('kode_user', 10)->nullable();
        //     $table->string('id_peg', 10)->nullable();
        //     $table->string('id_tipe_user', 10)->nullable();
        //     $table->string('username', 50)->nullable();
        //     $table->string('password', 50)->nullable();
        //     $table->timestamps();
        // });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_user', 10)->nullable();
            $table->string('role', 10)->nullable();
            $table->string('id_poli', 5)->nullable();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('tipe_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_tipe_user', 5);
            $table->string('tipe_user', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('tipe_user');
    }
}
