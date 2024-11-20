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
        Schema::table('checkin_item_variation', function (Blueprint $table) {
            $table->bigInteger('unit_id')->nullable();
            $table->decimal('weight', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkin_item_variation', function (Blueprint $table) {
            $table->dropColumn('unit_id');
            $table->decimal('weight', 10, 2)->nullable()->change();
        });
    }
};
