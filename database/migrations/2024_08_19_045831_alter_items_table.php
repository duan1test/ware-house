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
        Schema::table('items', function (Blueprint $table) {
            $table->text('details')->nullable()->change();
            $table->boolean('track_quantity')->default(false)->change();
            $table->boolean('track_weight')->default(false)->change();
            $table->boolean('has_variants')->default(false)->change();
            $table->boolean('has_serials')->default(false)->change();
            $table->bigInteger('alert_quantity')->nullable()->change();
            $table->string('rack_location')->nullable()->change();
            $table->string('photo')->nullable()->change();
            $table->string('sku')->nullable()->change();
            $table->string('symbology')->nullable()->change();
            $table->string('variants')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
