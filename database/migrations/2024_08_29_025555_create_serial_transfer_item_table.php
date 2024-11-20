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
        Schema::create('serial_transfer_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transfer_item_id');
            $table->bigInteger('serial_id');
            $table->integer('quantity');
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_transfer_item');
    }
};
