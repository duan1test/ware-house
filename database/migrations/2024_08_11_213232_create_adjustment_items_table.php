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
        Schema::create('adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('adjustment_id')->nullable();
            $table->bigInteger('item_id')->nullable();
            $table->decimal('weight', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->bigInteger('unit_id')->nullable();
            $table->string('batch_no')->nullable();
            $table->date('expiry_date');
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->boolean('draft')->default(false);
            $table->string('type');
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjustment_items');
    }
};
