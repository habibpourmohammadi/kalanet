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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("province_id")->constrained("provinces");
            $table->foreignId("city_id")->constrained("cities");
            $table->text("address");
            $table->string("postal_code");
            $table->string("mobile");
            $table->integer("no")->nullable();
            $table->integer("unit")->nullable();
            $table->string("recipient_first_name")->nullable();
            $table->string("recipient_last_name")->nullable();
            $table->string("recipient_mobile")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
