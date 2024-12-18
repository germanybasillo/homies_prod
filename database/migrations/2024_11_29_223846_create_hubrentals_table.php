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
        Schema::create('hubrentals', function (Blueprint $table) {
	$table->id();
	$table->foreignId('user_id')->constrained()->onDelete('cascade'); 
	$table->string('name');
	$table->string('address');
        $table->decimal('lat', 10, 6);  // Latitude
        $table->decimal('lng', 10, 6);  // Longitude
        $table->string('price');
	$table->string('type');
        $table->enum('status', ['pending', 'paid'])->default('pending');
        $table->timestamps();	
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hubrentals');
    }
};
