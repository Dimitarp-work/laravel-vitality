<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('emoji', 4)->default('🎯');
            $table->integer('xp')->default(50);
            $table->integer('progress')->default(0);
            $table->integer('streak')->default(0);
            $table->dateTime('deadline')->nullable();
            $table->boolean('achieved')->default(false);
            $table->dateTime('achieved_at')->nullable();
            $table->boolean('notified_about_deadline')->default(false);
            $table->dateTime('last_progress_date')->nullable();
            $table->integer('duration_value')->nullable();
            $table->enum('duration_unit', ['hours', 'days'])->nullable();
            $table->timestamps();

            $table->index(['user_id', 'deadline']);
            $table->index(['achieved', 'notified_about_deadline']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
