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
        Schema::create('job_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("job_opportunity_id")->constrained("job_opportunities");
            $table->text("description")->nullable();
            $table->text("file_path")->comment("Saving the resume file path");
            $table->enum("seen_status", ["viewed", "unviewed"])->default("unviewed");
            $table->enum("approval_status", ["pending", "approved", "rejected"])->default("pending");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_requests');
    }
};
