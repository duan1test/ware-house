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
        Schema::create('checkout_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('checkout_id');
            $table->bigInteger('item_id');
            $table->decimal('weight', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->bigInteger('unit_id');
            $table->string('batch_no');
            $table->date('expiry_date');
            $table->bigInteger('account_id');
            $table->boolean('draft')->default(false);
            $table->bigInteger('warehouse_id');
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkout_items');
    }
};
