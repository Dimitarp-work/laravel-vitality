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
     Schema::create('store_items', function (Blueprint $table) {
    $table->id();
    $table->string('item_type');
    $table->unsignedBigInteger('item_id');
    $table->string('category');
    $table->decimal('price', 8, 2)->default(0);
    $table->timestamps();
    $table->json('style')->nullable();

    $table->unique(['item_type', 'item_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_items');
    }
};
