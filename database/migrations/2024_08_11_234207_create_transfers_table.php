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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference');
            $table->boolean('draft')->default(true);
            $table->string('hash')->nullable();
            $table->bigInteger('to_warehouse_id');
            $table->bigInteger('from_warehouse_id');
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('approved_by')->nullable();
            $table->bigInteger('account_id')->nullable();
            $table->text('details')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
