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
        $table->unsignedBigInteger('xp')->default(0);
        $table->unsignedBigInteger('credits')->default(0);
        $table->unsignedInteger('level')->default(1);
    });
}
public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['xp', 'credits', 'level']);
    });
}

};
