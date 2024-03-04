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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("tracking_id")->unique();
            $table->foreignId("user_id")->constrained("users")->nullable();
            $table->foreignId("address_id")->constrained("addresses")->nullable();
            $table->foreignId("delivery_id")->constrained("deliveries")->nullable();
            $table->string("total_price")->nullable();
            $table->text("user_obj")->nullable();
            $table->text("address_obj")->nullable();
            $table->text("delivery_obj")->nullable();
            $table->enum("payment_status", ["paid", "unpaid", "returned", "canceled"])->default("unpaid");
            $table->enum("delivery_status", ["unpaid", "processing", "delivered"])->default("unpaid");
            $table->enum("status", ["confirmed", "not_confirmed"])->default("not_confirmed");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
