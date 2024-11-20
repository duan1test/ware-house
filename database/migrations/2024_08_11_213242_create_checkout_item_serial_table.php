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
        Schema::create('checkout_item_serial', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('checkout_item_id');
            $table->bigInteger('serial_id');
            $table->decimal('quantity', 10, 2);
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_item_serial');
    }
};
