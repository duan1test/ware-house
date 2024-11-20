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
        Schema::create('serials', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->boolean('sold')->default(false);
            $table->bigInteger('item_id');
            $table->bigInteger('account_id');
            $table->bigInteger('warehouse_id');
            $table->bigInteger('check_in_id')->nullable();
            $table->bigInteger('check_in_item_id')->nullable();
            $table->bigInteger('check_out_id')->nullable();
            $table->bigInteger('check_out_item_id')->nullable();
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serials');
    }
};
