<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('prd_id');
            $table->string('prd_name', 255);
            $table->text('description')->nullable();
            $table->unsignedInteger('brand_id');  // Foreign key to brands
            $table->decimal('price', 10, 0);
            $table->integer('quantity')->unsigned();
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('id_admin');  // Foreign key to ac_admin
            $table->timestamps();

            $table->foreign('brand_id')->references('brand_id')->on('brands')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('ac_admin')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
