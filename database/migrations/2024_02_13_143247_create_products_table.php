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
            $table->foreignId("category_id")->constrained("categories");
            $table->foreignId("brand_id")->constrained("brands");
            $table->foreignId("seller_id")->constrained("users");
            $table->string("name");
            $table->text("description");
            $table->text("Introduction_video_path")->nullable();
            $table->string('slug')->unique();
            $table->bigInteger("price");
            $table->integer('sold_number')->default(0);
            $table->integer('marketable_number')->default(0);
            $table->enum("marketable", ["true", "false"])->default("true");
            $table->enum("status", ["true", "false"])->default("true");
            $table->timestamps();
            $table->softDeletes();
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
