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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('product_name', 20);
            $table->string('product_photo')->nullable();
            $table->decimal('product_price', 10, 2);
            $table->text('product_description')->nullable();
            $table->tinyInteger('is_active')->default();

            //mengkoneksikan table relasi products dengan categories (one to many) satu kategori mempunyai banyak produk/banyak produk memiliki satu kategori
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
