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
        Schema::create('notifications', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['like', 'comment', 'follow', 'repost', 'mention']);
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->foreignId('related_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('tweet_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
