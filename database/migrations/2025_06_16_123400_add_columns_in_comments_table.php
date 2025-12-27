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
         Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->unsignedBigInteger('post_id')->after('user_id');
            $table->text('comment_text')->after('post_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) { 
            $table->dropColumn(['user_id', 'post_id','comment_text']);
        });
    }
};
