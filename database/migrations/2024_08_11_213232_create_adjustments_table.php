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
        Schema::create('adjustments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference');
            $table->boolean('draft')->default(false);
            $table->string('type');
            $table->unsignedInteger('warehouse_id');
            $table->unsignedInteger('user_id');
            $table->string('hash');
            $table->unsignedInteger('approved_by')->nullable();
            $table->unsignedInteger('account_id')->nullable();
            $table->text('details')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjustments');
    }
};
