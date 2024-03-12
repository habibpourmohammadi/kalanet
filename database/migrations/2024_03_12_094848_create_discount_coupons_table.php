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
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string("coupon")->unique();
            $table->string("amount")->nullable();
            $table->foreignId("user_id")->nullable()->constrained("users");
            $table->string("discount_limit")->nullable();
            $table->timestamp("start_date")->useCurrent();
            $table->timestamp("end_date")->useCurrent();
            $table->enum("unit", ["percent", "price"])->default("percent");
            $table->enum("type", ["public", "private"])->default("public");
            $table->enum("status", ["active", "deactive"])->default("active");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};
