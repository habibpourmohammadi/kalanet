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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->constrained("orders");
            $table->string("amount")->nullable();
            $table->string("token")->nullable();
            $table->string("transaction_id")->nullable();
            $table->text("first_bank_response")->nullable();
            $table->text("second_bank_response")->nullable();
            $table->enum("payment_status", ["paid", "", "unpaid"])->default("unpaid");
            $table->enum("status", ["online", "cash"])->default("online");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
