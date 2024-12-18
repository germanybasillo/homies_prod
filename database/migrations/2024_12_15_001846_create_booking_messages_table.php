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
        Schema::create('booking_messages', function (Blueprint $table) {
	$table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->foreignId('selected_id')->constrained()->onDelete('cascade'); 
	    $table->string('address');
            $table->date('start_date'); 
            $table->date('due_date'); 
	    $table->enum('status', ['pending', 'approaved'])->default('pending');
	    $table->unsignedInteger('count')->default(0);
	    $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_messages');
    }
};
