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
        Schema::create('checkin_item_variation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('checkin_item_id');
            $table->bigInteger('variation_id');
            $table->decimal('quantity', 10, 2);
            $table->decimal('weight', 10, 2);
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkin_item_variation');
    }
};
