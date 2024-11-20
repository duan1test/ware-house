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
        Schema::create('stock_trails', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->bigInteger('warehouse_id');
            $table->decimal('quantity', 10, 2);
            $table->enum('type', ['IN', 'OUT']);
            $table->text('memo')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->bigInteger('variation_id')->nullable();
            $table->bigInteger('unit_id')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_trails');
    }
};
