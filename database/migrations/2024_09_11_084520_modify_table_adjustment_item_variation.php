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
        Schema::table('adjustment_item_variation', function (Blueprint $table) {
            $table->decimal('quantity', 15, 2)->default(0);
            $table->bigInteger('unit_id')->default(null);
            $table->dropColumn('account_id');
            $table->decimal('weight', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adjustment_item_variation', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('unit_id');
            $table->bigInteger('account_id')->nullable();
            $table->dropColumn('weight');
        });
    }
};
