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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_id');
            $table->string('code');
            $table->string('details');
            $table->boolean('track_quantity')->default(false);
            $table->decimal('track_weight', 10, 2);
            $table->boolean('has_variants')->default(false);
            $table->boolean('has_serials')->default(false);
            $table->bigInteger('alert_quantity');
            $table->string('rack_location');
            $table->string('unit_id');
            $table->string('photo');
            $table->string('sku');
            $table->string('name');
            $table->string('symbology');
            $table->string('variants');
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
