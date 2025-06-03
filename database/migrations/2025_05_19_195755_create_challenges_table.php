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

            // basic info
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();

            // difficulty + duration
            $table->enum('difficulty', ['Beginner', 'Intermediate', 'Advanced']);
            $table->unsignedInteger('duration_days'); // total length of challenge

            // XP + badge (XP badge_id will be foreign key when we will have the tables)
            $table->unsignedInteger('xp_reward')->default(0);
            $table->string('badge_id')->nullable();

            // challenge state
            $table->enum('status', ['available', 'active', 'completed'])->default('available');
            $table->date('start_date')->nullable(); // when the challenge starts

            // foreign key for the creator (renaming to creator_id for clarity)
            $table->foreignId('creator_id')->nullable()->constrained('users')->nullOnDelete();


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
