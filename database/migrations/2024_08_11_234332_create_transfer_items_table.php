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
        Schema::create('transfer_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transfer_id');
            $table->bigInteger('item_id');
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('quantity', 10, 2);
            $table->bigInteger('unit_id')->nullable();
            $table->string('batch_no', 50)->nullable();
            $table->date('expiry_date')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->boolean('draft')->default(false);
            $table->bigInteger('to_warehouse_id');
            $table->bigInteger('from_warehouse_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_items');
    }
};
