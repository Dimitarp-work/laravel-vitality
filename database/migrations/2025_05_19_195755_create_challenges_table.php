<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->enum('difficulty', ['Beginner', 'Intermediate', 'Advanced']);
            $table->unsignedInteger('duration_days');
            $table->unsignedInteger('participants')->default(0);
            $table->string('badge_id')->nullable(); // This could be a foreign key if you later make a badges table
            $table->unsignedInteger('xp_reward')->default(0);
            $table->enum('status', ['available', 'active', 'completed'])->default('available');
            $table->unsignedInteger('progress')->nullable();
            $table->unsignedInteger('days_completed')->nullable();
            $table->unsignedInteger('total_days')->nullable();

            //Optional author
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
