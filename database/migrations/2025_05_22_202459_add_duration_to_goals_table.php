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
        Schema::table('goals', function (Blueprint $table) {
            if (!Schema::hasColumn('goals', 'duration_value')) {
                $table->integer('duration_value')->nullable()->after('xp');
            }

            if (!Schema::hasColumn('goals', 'duration_unit')) {
                $table->enum('duration_unit', ['hours', 'days'])->nullable()->after('duration_value');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            if (Schema::hasColumn('goals', 'duration_value')) {
                $table->dropColumn('duration_value');
            }

            if (Schema::hasColumn('goals', 'duration_unit')) {
                $table->dropColumn('duration_unit');
            }
        });
    }
};
