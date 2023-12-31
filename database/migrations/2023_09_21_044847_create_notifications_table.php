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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_from')->nullable();
            $table->foreign('notification_from')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('notification_to')->nullable();
            $table->foreign('notification_to')->references('id')->on('users')->onDelete('cascade');
            $table->string('notification_type')->default("");
            $table->string('notification')->default("");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
