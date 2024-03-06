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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("banner_path");
            $table->integer("banner_size");
            $table->string("banner_type");
            $table->text("url")->nullable();
            $table->enum("status", ["true", "false"])->default("true");
            $table->enum("banner_position", ["topLeft", "middle", "bottom"])->comment("top left => two banners , middle => two banners, bottom => one banner");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
