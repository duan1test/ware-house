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
        Schema::table('checkins', function (Blueprint $table) {
            $table->text('details')->nullable()->change();
            $table->bigInteger('contact_id')->nullable()->change();
            $table->bigInteger('approved_by')->nullable()->change();
            $table->json('extra_attributes')->nullable()->change();
            $table->date('approved_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkins', function (Blueprint $table) {
            $table->text('details')->nullable()->change();
            $table->bigInteger('contact_id')->nullable()->change();
            $table->bigInteger('approved_by')->nullable()->change();
            $table->json('extra_attributes')->nullable()->change();
            $table->date('approved_at')->nullable()->change();
        });
    }
};
