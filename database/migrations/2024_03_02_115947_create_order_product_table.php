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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->constrained("orders")->nullable();
            $table->foreignId("product_id")->constrained("products")->nullable();
            $table->string("color_name")->nullable();
            $table->string("color_hex_code")->nullable();
            $table->string("color_price")->nullable();
            $table->string("guarantee_persian_name")->nullable();
            $table->string("guarantee_price")->nullable();
            $table->string("product_price")->default(0);
            $table->string("number");
            $table->string("total_price")->default(0);
            $table->text("product_obj")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
