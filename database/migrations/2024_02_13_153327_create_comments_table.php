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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("parent_id")->nullable()->constrained("comments");
            $table->foreignId("product_id")->nullable()->constrained("products");
            $table->foreignId("user_id")->nullable()->constrained("users");
            $table->text("comment");
            $table->enum("status", ["true", "false"])->default("false");
            $table->enum("seen", ["true", "false"])->default("false");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
