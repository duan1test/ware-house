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
        Schema::create('units', function (Blueprint $table) {
            $table->id(); 
            $table->string('name'); 
            $table->bigInteger('base_unit_id')->nullable(); 
            $table->bigInteger('account_id')->default(1); 
            $table->string('code')->nullable()->unique(); 
            $table->decimal('operation_value', 10, 2)->nullable();
            $table->string('operator')->nullable(); 
            $table->index('base_unit_id');
            $table->index('account_id');
            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
