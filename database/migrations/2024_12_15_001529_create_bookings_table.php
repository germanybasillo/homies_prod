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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reference to tenant
            $table->foreignId('selected_id')->constrained()->onDelete('cascade'); // Reference to room
	    $table->foreignId('selectbed_id')->constrained()->onDelete('cascade'); // Reference to room
	    $table->string('name');
            $table->string('address');
            $table->date('check_in'); // Check-in date
            $table->date('check_out'); // Check-out date
	    $table->enum('status', ['pending', 'cancel','confirmed'])->default('pending');
            $table->unsignedInteger('count')->default(0);
            $table->timestamps(); // Created at & updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
