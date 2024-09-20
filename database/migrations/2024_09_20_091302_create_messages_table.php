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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_parent_id')->nullable();
            $table->unsignedBigInteger('sender_agent_id')->nullable();
            $table->unsignedBigInteger('receiver_parent_id')->nullable();
            $table->unsignedBigInteger('receiver_agent_id')->nullable();
           
            $table->text('message');

            $table->foreign('sender_parent_id')->references('id')->on('parents')->cascadeOnDelete();
            $table->foreign('sender_agent_id')->references('id')->on('agents')->cascadeOnDelete();
            $table->foreign('receiver_parent_id')->references('id')->on('parents')->cascadeOnDelete();
            $table->foreign('receiver_agent_id')->references('id')->on('agents')->cascadeOnDelete();
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
