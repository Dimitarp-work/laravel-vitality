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
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('banner_id')->nullable()->constrained('banners')->nullOnDelete();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['banner_id']); 
        $table->dropColumn('banner_id');
    });
    }
};
