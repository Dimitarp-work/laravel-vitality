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
        Schema::create('daily_check_ins', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('isComplete');
            $table->boolean('isRecurring')->default(true);
            $table->unsignedBigInteger('stampcard_id');
            $table->foreign('stampcard_id')->references('user_id')->on('stampcards')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_check_ins');
    }
};
