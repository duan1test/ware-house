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
        Schema::table('checkin_items', function (Blueprint $table) {
            $table->bigInteger('unit_id')->nullable()->change();
            $table->string('batch_no')->nullable()->change();
            $table->date('expiry_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkin_items', function (Blueprint $table) {
            $table->bigInteger('unit_id')->nullable()->change();
            $table->string('batch_no')->nullable()->change();
            $table->date('expiry_date')->nullable()->change();
        });
    }
};
