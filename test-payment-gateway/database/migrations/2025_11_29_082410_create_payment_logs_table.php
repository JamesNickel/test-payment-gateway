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
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_id');
            $table->enum('status', [
                'none',
                'init',
                'init_failed',
                'init_success',
                'verify',
                'verify_failed',
                'verify_success',
            ])->default('none');
            $table->string('bank_status')->nullable();
            $table->string('raw_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};
