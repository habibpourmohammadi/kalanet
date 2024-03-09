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
        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("ticket_id")->constrained("tickets");
            $table->foreignId("user_id")->constrained("users");
            $table->text("message")->nullable();
            $table->text("file_path")->nullable();
            $table->enum("isAdmin", ["true", "false"])->default("false");
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
        Schema::dropIfExists('ticket_messages');
    }
};
