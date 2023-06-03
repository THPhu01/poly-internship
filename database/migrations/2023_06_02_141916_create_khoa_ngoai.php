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
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
        Schema::table('product', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('product_category')->cascadeOnDelete();
            $table->foreign('brand_id')->references('id')->on('product_brand')->cascadeOnDelete();
        });

        Schema::table('product_comments', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('product')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('product_details', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('product')->cascadeOnDelete();
        });

        Schema::table('orders_details', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('product')->cascadeOnDelete();
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['brand_id']);
        });
        Schema::table('product_comments', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('orders_details', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['order_id']);
        });
    }
};
