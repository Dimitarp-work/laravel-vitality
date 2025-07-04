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
    Schema::table('store_items', function (Blueprint $table) {
        // Only add these if they are missing from create_store_items_table
        if (!Schema::hasColumn('store_items', 'type')) {
            $table->string('type')->default('banner');
        }
        if (!Schema::hasColumn('store_items', 'image_url')) {
            $table->string('image_url')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('store_items', function (Blueprint $table) {
        $table->dropColumn(['item_id', 'item_type', 'category', 'price', 'type', 'image_url']);
    });
}
};
