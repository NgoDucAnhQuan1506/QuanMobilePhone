<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ac_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('us_name', 50)->nullable();
            $table->string('username', 20)->nullable()->unique();
            $table->string('password', 255)->nullable();
            $table->string('Sdt', 10)->nullable();
            $table->string('email', 255)->unique();
            $table->string('dc_nhanhang', 255)->nullable();
            $table->string('thanhpho', 100)->nullable();
            $table->timestamps();
            $table->unsignedInteger('id_admin')->nullable();

            $table->foreign('id_admin')->references('id_admin')->on('ac_admin')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ac_users');
    }
};
