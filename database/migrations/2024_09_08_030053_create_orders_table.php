<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_code', 50);
            $table->unsignedBigInteger('user_id');  // Foreign key to ac_users
            $table->string('customer_name', 255);
            $table->string('customer_note')->nullable();
            $table->string('customer_phone', 20);
            $table->string('customer_email', 255);
            $table->string('shipping_address', 255);
            $table->tinyInteger('status')->default(0);
            $table->string('product_name', 255);
            $table->decimal('product_price', 10, 0);
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('total_price', 15, 0);
            $table->timestamps();
            $table->unsignedInteger('id_admin')->nullable();

            $table->foreign('user_id')->references('id')->on('ac_users')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('ac_admin')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
