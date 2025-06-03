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
        Schema::table('goals', function (Blueprint $table) {
            if (!Schema::hasColumn('goals', 'deadline')) {
                $table->dateTime('deadline')->nullable()->after('duration_unit');
            }

            if (!Schema::hasColumn('goals', 'notified_about_deadline')) {
                $table->boolean('notified_about_deadline')->default(false)->after('deadline');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            if (Schema::hasColumn('goals', 'notified_about_deadline')) {
                $table->dropColumn('notified_about_deadline');
            }

            if (Schema::hasColumn('goals', 'deadline')) {
                $table->dropColumn('deadline');
            }
        });
    }
};
