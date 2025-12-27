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
        Schema::create('stories', function (Blueprint $table) {
            $table->id(); // Primary key: 'id' (auto-incrementing big integer)
            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // 'user_id' is a foreign key referencing 'id' on the 'users' table
            // The 'constrained()' method assumes 'users' as the referenced table
            // 'onDelete('cascade')' ensures related stories are deleted when a user is deleted
            
            $table->string('image_path')->nullable(); // To store the image file path or URL(can be nullable)
            
            $table->timestamp('expires_at')->index(); // For when the story expires
            
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
