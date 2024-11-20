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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('reference');
            $table->boolean('draft')->default(false);
            $table->bigInteger('contact_id');
            $table->bigInteger('warehouse_id');
            $table->bigInteger('user_id');
            $table->string('hash');
            $table->bigInteger('approved_by');
            $table->bigInteger('account_id');
            $table->string('details');
            $table->json('extra_attributes');
            $table->date('approved_at');
            $table->timestamps(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
