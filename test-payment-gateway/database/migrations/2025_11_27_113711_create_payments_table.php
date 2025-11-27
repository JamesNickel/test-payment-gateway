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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->float('amount');
            $table->string('request_number')->unique();
            $table->string('tracking_code')->unique();
            $table->string('url')->unique();
            $table->string('status')->unique();
            $table->string('response_data')->unique();
            $table->string('gateway')->unique();
            $table->string('gateway_request_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
