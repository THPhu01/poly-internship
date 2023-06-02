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
        Schema::create('product', function (Blueprint $table) {
            $table->id();

            $table->integer('brand_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('name');
            $table->double('price');
            $table->text('desc')->nullable();
            $table->text('content')->nullable();
            $table->string('image');
            $table->integer('qty');
            $table->tinyText('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
