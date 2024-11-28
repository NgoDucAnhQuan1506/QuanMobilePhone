<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Thêm cột product_id
            $table->unsignedInteger('prd_id')->after('total_price');

            // Thêm khóa ngoại cho cột product_id
            $table->foreign('prd_id')
                ->references('prd_id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa ràng buộc khóa ngoại
            $table->dropForeign(['prd_id']);
            
            // Xóa cột product_id
            $table->dropColumn('prd_id');
        });
    }
};
