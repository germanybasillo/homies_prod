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
        Schema::create('selecteds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('room_no');
            $table->string('description');
            $table->string('profile1')->nullable();
            $table->string('profile2')->nullable();
            $table->string('profile3')->nullable();
            $table->string('profile4')->nullable();
            $table->string('profile5')->nullable();
            $table->string('profile6')->nullable();
            $table->string('caption1')->nullable();
            $table->string('caption2')->nullable();
            $table->string('caption3')->nullable();
            $table->string('caption4')->nullable();
            $table->string('caption5')->nullable();
	    $table->string('caption6')->nullable();
	    $table->string('bed_no');
            $table->foreignId('hubrental_id')->constrained()->onDelete('cascade'); 
            $table->enum('bed_status', ['available', 'occupied'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selecteds');
    }
};
