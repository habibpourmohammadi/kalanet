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
        Schema::create('general_discounts', function (Blueprint $table) { 
            $table->id();
            $table->string("amount")->nullable();
            $table->string("discount_limit")->nullable();
            $table->timestamp("start_date")->useCurrent();
            $table->timestamp("end_date")->useCurrent();
            $table->enum("unit", ["percent", "price"])->default("percent");
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
        Schema::dropIfExists('general_discounts');
    }
};
